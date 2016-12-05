<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    /**
     * @var string
     */
    protected $table = 'category';

    /**
     * @var array
     */
    protected $fillable = [
        'content',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'content' => 'array',
    ];

    /**
     * Closure table name for this model.
     *
     * @var string
     */
    protected $closure;
    /**
     * Indicates if the model should soft delete.
     *
     * @var bool
     */
    protected $softDelete = true;
    /**
     * The position column name.
     *
     * @var string
     */
    const POSITION = 'position';
    /**
     * The ancestor column name.
     *
     * @var string
     */
    const ANCESTOR = 'ancestor';
    /**
     * The descendant column name.
     *
     * @var string
     */
    const DESCENDANT = 'descendant';
    /**
     * The depth column name.
     *
     * @var string
     */
    const DEPTH = 'depth';

    /**
     * Model constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (! isset($this->closure)) {
            $this->closure = $this->getTable().'_closure';
        }
        // Here we add position column to fillables
        $this->fillable(array_merge($this->getFillable(), [$this->getPositionColumn()]));
    }

    /**
     * Create new model and automatically set its position if it's not provided.
     *
     * @param array $attributes
     * @return Entity
     */
    public static function make(array $attributes = [])
    {
        $model = new static();
        // Workaround to set the position
        if (! isset($attributes[static::POSITION])) {
            // When making, we assume that the model
            // will be a root node in the tree,
            // so we set its depth to zero.
            $model->hidden[static::DEPTH] = 0;
            $attributes[static::POSITION] = $model->guessPositionOnCreate();
        }
        $model->fill($attributes);

        return $model;
    }

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return Entity|static
     */
    public static function create(array $attributes)
    {
        $model = static::make($attributes);
        $model->save();
        $model->setHidden($model->getClosureAttributes());

        return $model;
    }

    /**
     * Get the closure table associated with the model.
     *
     * @return string
     */
    public function getClosure()
    {
        return $this->closure;
    }

    /**
     * Get closure table column values on the model.
     *
     * @return array
     */
    protected function getClosureAttributes()
    {
        $closure = DB::table($this->getClosure())->where(static::DESCENDANT, '=', $this->getKey());
        $depth = $closure->max(static::DEPTH);
        $columns = [static::ANCESTOR, static::DESCENDANT, static::DEPTH];

        return (array) $closure->where(static::DEPTH, '=', $depth)->first($columns);
    }

    /**
     * Get ancestor attribute from the model.
     *
     * @return int
     */
    protected function getAncestor()
    {
        return $this->hidden[static::ANCESTOR];
    }

    /**
     * Get descendant attribute from the model.
     *
     * @return int
     */
    protected function getDescendant()
    {
        return $this->hidden[static::DESCENDANT];
    }

    /**
     * Get depth attribute on the model.
     *
     * @return int
     */
    public function getDepth()
    {
        return $this->hidden[static::DEPTH];
    }

    /**
     * Prepare selected columns array for further use.
     *
     * @param array $columns
     * @return array
     */
    protected function getSelectedColumns(array $columns = ['*'])
    {
        if ($columns === ['*']) {
            return [$this->getTable().'.*'];
        }

        return $columns;
    }

    /**
     * Get direct model ancestor.
     *
     * @param array $columns
     * @return Entity|null
     */
    public function parent(array $columns = ['*'])
    {
        return $this->select($this->getSelectedColumns($columns))
            ->join($this->getClosure(), $this->getQualifiedAncestorKeyName(), '=', $this->getQualifiedKeyName())
            ->where($this->getQualifiedDescendantKeyName(), '=', $this->getKey())
            ->where($this->getQualifiedDepthKeyName(), '=', 1)
            ->first();
    }

    /**
     * Build query for the model ancestors.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildAncestorsQuery(array $columns = ['*'])
    {
        $ak = $this->getQualifiedAncestorKeyName();
        $dk = $this->getQualifiedDescendantKeyName();
        $dpk = $this->getQualifiedDepthKeyName();

        return $this->select($this->getSelectedColumns($columns))
            ->join($this->getClosure(), $ak, '=', $this->getQualifiedKeyName())
            ->where($dk, '=', $this->getKey())
            ->where($dpk, '>', 0);
    }

    /**
     * Get all model ancestors.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function ancestors(array $columns = ['*'])
    {
        return $this->buildAncestorsQuery($columns)->get();
    }

    /**
     * Check if the model has any ancestors.
     *
     * @return bool
     */
    public function hasAncestors()
    {
        return (bool) $this->countAncestors();
    }

    /**
     * Count model ancestors.
     *
     * @return int
     */
    public function countAncestors()
    {
        return (int) $this->buildAncestorsQuery()->count();
    }

    /**
     * Build query for the direct model descendants.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildChildrenQuery(array $columns = ['*'])
    {
        $ak = $this->getQualifiedAncestorKeyName();
        $dk = $this->getQualifiedDescendantKeyName();
        $dpk = $this->getQualifiedDepthKeyName();

        return $this->select($this->getSelectedColumns($columns))
            ->join($this->getClosure(), $dk, '=', $this->getQualifiedKeyName())
            ->where($ak, '=', $this->getKey())
            ->where($dpk, '=', 1);
    }

    /**
     * Get direct model descendants.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function children(array $columns = ['*'])
    {
        $result = (isset($this->nested) ? $this->nested : $this->buildChildrenQuery($columns)->get());

        return $result;
    }

    /**
     * Check if the model has direct descendants.
     *
     * @return bool
     */
    public function hasChildren()
    {
        return (bool) $this->countChildren();
    }

    /**
     * Count direct model descendants.
     *
     * @return int
     */
    public function countChildren()
    {
        $result = (isset($this->nested) ? (int) $this->nested->count() : (int) $this->buildChildrenQuery()->count());

        return $result;
    }

    /**
     * Get the first direct descendant of the model.
     *
     * @param array $columns
     * @return Entity
     */
    public function firstChild(array $columns = ['*'])
    {
        return $this->childAt(0, $columns);
    }

    /**
     * Get the last direct descendant of the model.
     *
     * @param array $columns
     * @return Entity
     */
    public function lastChild(array $columns = ['*'])
    {
        $max = $this->buildChildrenQuery()->max(static::POSITION);

        return $this->childAt($max, $columns);
    }

    /**
     * Get direct descendant at given position.
     *
     * @param $position
     * @param array $columns
     * @return Entity
     */
    public function childAt($position, array $columns = ['*'])
    {
        $result = null;
        if (isset($this->nested)) {
            if (isset($this->nested[$position])) {
                $result = $this->nested[$position];
            }
        } else {
            $result = $this->buildChildrenQuery($columns)->where(static::POSITION, '=', $position)->first();
        }

        return $result;
    }

    /**
     * Insert a model as a direct descendant of this one.
     *
     * @param Category $child
     * @param int|null $position
     * @param bool $returnChild
     * @return Entity
     */
    public function appendChild(Category $child, $position = null, $returnChild = false)
    {
        $child->moveTo($this, $position);

        return $returnChild === true ? $child : $this;
    }

    /**
     * Remove a direct descendant with given position.
     *
     * @param int|null $position
     * @param bool $forceDelete
     * @return Entity
     */
    public function removeChild($position = null, $forceDelete = false)
    {
        $child = null;
        $position = (int) $position;
        if (isset($this->nested) && isset($this->nested[$position])) {
            $child = $this->nested[$position];
        } else {
            $child = $this->buildChildrenQuery()->where(static::POSITION, '=', (int) $position)->first();
        }
        if ($child !== null) {
            if ($forceDelete === true) {
                $child->forceDelete();
            } else {
                $child->delete();
            }
        }

        return $this;
    }

    /**
     * Build query for the model descendants.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildDescendantsQuery(array $columns = ['*'])
    {
        $ak = $this->getQualifiedAncestorKeyName();
        $dk = $this->getQualifiedDescendantKeyName();
        $dpk = $this->getQualifiedDepthKeyName();

        return $this->select($this->getSelectedColumns($columns))
            ->join($this->getClosure(), $dk, '=', $this->getQualifiedKeyName())
            ->where($ak, '=', $this->getKey())
            ->where($dpk, '>', 0);
    }

    /**
     * Get all model descendants.
     *
     * @param int|null $depth depth relative to the model's depth
     * @param bool $flat
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function descendants($depth = null, $flat = false, array $columns = ['*'])
    {
        $query = $this->buildDescendantsQuery($columns);
        if ($depth !== null) {
            $query->where($this->getQualifiedDepthKeyName(), '=', $depth);
        }
        $query = $query->get();
        if ($flat === false) {
            return $query->toTree();
        }

        return $query;
    }

    /**
     * Check if the model has any descendants.
     *
     * @return bool
     */
    public function hasDescendants()
    {
        return (bool) $this->countDescendants();
    }

    /**
     * Count the model descendants.
     *
     * @return int
     */
    public function countDescendants()
    {
        return (int) $this->buildDescendantsQuery()->count();
    }

    /**
     * Build query for siblings of the model.
     *
     * @param string $direction
     * @param bool $queryAll
     * @param int|null $position
     * @param array $columns
     * @throws \InvalidArgumentException
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildSiblingsQuery($direction = 'both', $queryAll = true, $position = null, array $columns = ['*'])
    {
        if (! in_array($direction, ['next', 'prev', 'both'])) {
            throw new \InvalidArgumentException('Invalid direction value.');
        }
        $query = $this->buildSiblingsSubquery($columns);
        $operand = '';
        $wherePos = null;
        switch ($direction) {
            case 'prev':
                $operand = '<';
                $wherePos = $position - 1;
                break;
            case 'next':
                $operand = '>';
                $wherePos = $position + 1;
                break;
            case 'both':
                $operand = '<>';
                $wherePos = [$position - 1, $position + 1];
        }
        if ($queryAll === true) {
            $query->where(static::POSITION, $operand, $position);
        } else {
            if ($direction == 'both') {
                $query->whereIn(static::POSITION, $wherePos);
            } else {
                $query->where(static::POSITION, '=', $wherePos);
            }
        }

        return $query;
    }

    /**
     * Build a part of the siblings query.
     * This part defines a sibling regardless of direction (prev or next) and position.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildSiblingsSubquery(array $columns = ['*'])
    {
        $primaryKey = $this->getQualifiedKeyName();
        $primaryValue = $this->getKey();
        $columns = $this->getSelectedColumns($columns);
        $closure = $this->getClosure();
        $descendantKey = $this->getQualifiedDescendantKeyName();
        $depthKey = $this->getQualifiedDepthKeyName();
        $depthValue = $this->getDepth();
        // If the model is a root node then we must
        // query only the roots because the original
        // siblings query would give us wrong results.
        if ($this->isRoot()) {
            $query = $this->buildRootsQuery($columns)->where($primaryKey, '<>', $primaryValue);
        } else {
            $query = $this->select($columns)
                ->join($closure, $descendantKey, '=', $primaryKey)
                ->where($descendantKey, '<>', $primaryValue)
                ->where($depthKey, '=', $depthValue);
        }

        return $query;
    }

    /**
     * Retrieve previous or next model siblings.
     *
     * @param string $find number of the searched: 'all', 'one'
     * @param string $direction searching direction: 'prev', 'next', 'both'
     * @param int|null $position
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|Entity
     */
    public function siblings($find = 'all', $direction = 'both', $position = null, array $columns = ['*'])
    {
        $position = ($position === null ? $this->{static::POSITION} : $position);
        switch ($find) {
            case 'one':
                $result = $this->buildSiblingsQuery($direction, false, $position, $columns);
                if ($direction == 'both') {
                    $result = $result->get();
                } else {
                    $result = $result->first();
                }
                break;
            case 'all':
                $result = $this->buildSiblingsQuery($direction, true, $position, $columns)->get();
                break;
        }

        return $result;
    }

    /**
     * Get the first sibling of a model.
     *
     * @param array $columns
     * @return Entity
     */
    public function firstSibling(array $columns = ['*'])
    {
        return $this->siblingAt(0, $columns);
    }

    /**
     * Get the last sibling of a model.
     *
     * @param array $columns
     * @return Entity
     */
    public function lastSibling(array $columns = ['*'])
    {
        $lastpos = $this->buildSiblingsSubquery()->max(static::POSITION);

        return $this->siblingAt($lastpos, $columns);
    }

    /**
     * Get a sibling with given position.
     *
     * @param $position
     * @param array $columns
     * @return Entity
     */
    public function siblingAt($position, array $columns = ['*'])
    {
        return $this->siblings('one', 'next', $position - 1, $columns);
    }

    /**
     * Get a previous model sibling.
     *
     * @param array $columns
     * @return Entity
     */
    public function prevSibling(array $columns = ['*'])
    {
        return $this->siblings('one', 'prev', null, $columns);
    }

    /**
     * Get collection of previous model siblings.
     *
     * @param int|null $position
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function prevSiblings($position = null, array $columns = ['*'])
    {
        return $this->siblings('all', 'prev', $position, $columns);
    }

    /**
     * Check if the model has previous siblings.
     *
     * @return bool
     */
    public function hasPrevSiblings()
    {
        return (bool) $this->countPrevSiblings();
    }

    /**
     * Count previous siblings.
     *
     * @return int
     */
    public function countPrevSiblings()
    {
        return (int) $this->buildSiblingsQuery('prev', true, $this->{static::POSITION})->count();
    }

    /**
     * Get the next model sibling.
     *
     * @return Entity
     */
    public function nextSibling(array $columns = ['*'])
    {
        return $this->siblings('one', 'next', null, $columns);
    }

    /**
     * Get collection of the next model siblings.
     *
     * @param int|null $position
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function nextSiblings($position = null, array $columns = ['*'])
    {
        return $this->siblings('all', 'next', $position, $columns);
    }

    /**
     * Check if model has next siblings.
     *
     * @return bool
     */
    public function hasNextSiblings()
    {
        return (bool) $this->countNextSiblings();
    }

    /**
     * Count next siblings.
     *
     * @return int
     */
    public function countNextSiblings()
    {
        return (int) $this->buildSiblingsQuery('next', true, $this->{static::POSITION})->count();
    }

    /**
     * Check if model has siblings.
     *
     * @return bool
     */
    public function hasSiblings()
    {
        return (bool) $this->countSiblings();
    }

    /**
     * Count model siblings.
     *
     * @return int
     */
    public function countSiblings()
    {
        return (int) $this->buildSiblingsQuery('both', true, $this->{static::POSITION})->count();
    }

    /**
     * Builds query for the root nodes.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildRootsQuery(array $columns = ['*'])
    {
        $instance = new static;
        $closure = $instance->getClosure();
        $ancestor = static::ANCESTOR;
        $descendant = static::DESCENDANT;
        $depth = $instance->getQualifiedDepthKeyName();
        $keyName = $instance->getQualifiedKeyName();
        $whereRaw = "(select count(*) from {$closure}
                      where {$closure}.{$descendant} = tc.{$ancestor}
                      and {$depth} > 0) = 0";
        $columns = $instance->getSelectedColumns($columns);
        array_push($columns, 'tc.'.$ancestor);

        return static::select($columns)
            ->distinct()
            ->join($closure.' as tc', function ($join) use ($ancestor, $descendant, $keyName) {
                $join->on('tc.'.$ancestor, '=', $keyName);
                $join->on('tc.'.$descendant, '=', $keyName);
            })
            ->whereRaw($whereRaw);
    }

    /**
     * Retrieve all models that have no ancestors.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function roots(array $columns = ['*'])
    {
        return with(new static)->buildRootsQuery($columns)->get();
    }

    /**
     * Check if model is a top level one.
     *
     * @return bool
     */
    public function isRoot()
    {
        return (bool) DB::table($this->getClosure())
                ->where(static::DESCENDANT, '=', $this->getKey())
                ->where(static::DEPTH, '>', 0)
                ->count() == 0;
    }

    /**
     * Move the model and its relationships to the top level of the tree.
     *
     * @return Entity
     */
    public function makeRoot()
    {
        if (! $this->isRoot()) {
            $this->moveTo();
        }

        return $this;
    }

    /**
     * Retrive a whole tree from the database.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function tree(array $columns = ['*'])
    {
        return static::buildTreeQuery(null, null, null, $columns)->get()->toTree();
    }

    /**
     * Retrive from the database a tree filtered using a where clause.
     *
     * @param string|\Closure|null $column
     * @param string|null $operator
     * @param string|\Closure|null $value
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function filteredTree($column = null, $operator = null, $value = null, array $columns = ['*'])
    {
        return static::buildTreeQuery($column, $operator, $value, $columns)->get()->toTree();
    }

    /**
     * Builds query for retrieving a whole tree.
     *
     * @param string|\Closure|null $column
     * @param string|null $operator
     * @param string|\Closure|null $value
     * @param array $columns
     * @return \Illuminate\Database\Query\Builder
     */
    protected static function buildTreeQuery($column = null, $operator = null, $value = null, array $columns = ['*'])
    {
        $instance = new static;
        $closureColumns = [
            'closure1.'.static::ANCESTOR,
            'closure1.'.static::DESCENDANT,
            'closure1.'.static::DEPTH,
        ];
        $columns = array_merge($instance->getSelectedColumns($columns), $closureColumns);
        $key = $instance->getQualifiedKeyName();
        $closure = $instance->getClosure();
        $query = static::select($columns)
            ->distinct()
            ->join($closure.' as closure1', $key, '=', 'closure1.'.static::ANCESTOR)
            ->join($closure.' as closure2', $key, '=', 'closure2.'.static::DESCENDANT)
            ->whereRaw('closure1.'.static::ANCESTOR.' = closure1.'.static::DESCENDANT);
        if ($column != null && $operator != null) {
            $query->where($column, $operator, $value);
        }

        return $query;
    }

    /**
     * Make the model a root or a direct descendant of the given model.
     *
     * @param Entity|null $ancestor
     * @param int|null $position
     * @return Entity
     */
    public function moveTo(Entity $ancestor = null, $position = null)
    {
        return static::moveGivenTo($this, $ancestor, $position);
    }

    /**
     * Make given model a root or a direct descendant of another model.
     *
     * @param Entity|int $given
     * @param Entity|int|null $to
     * @param int|null $position
     * @return Entity
     */
    public static function moveGivenTo(Entity $given, Entity $to = null, $position = null)
    {
        if ($to instanceof Entity && $given->parent() instanceof Entity) {
            $toAndParentEquals = ($to->getKey() == $given->parent()->getKey());
        } else {
            $toAndParentEquals = ($to === null && $given->parent() === null);
        }
        $guessedPosition = $given->guessPositionOnMoveTo($to, $position);
        if ($toAndParentEquals && $given->{static::POSITION} = $guessedPosition) {
            return $given;
        }
        $given->{static::POSITION} = $guessedPosition;
        if ($given->exists) {
            $given->performMoveTo($to);
            $given->save();
        } else {
            $given->save();
            $given->performMoveTo($to);
            $given->setHidden($given->getClosureAttributes());
        }

        return $given;
    }

    /**
     * Set a proper position before moving the model.
     *
     * @param Entity|null $to
     * @param $position
     * @return int|mixed
     */
    protected function guessPositionOnMoveTo(Entity $to = null, $position)
    {
        if ($position === null) {
            $lastSibling = ($to === null ? null : $to->lastChild());
            $position = ($lastSibling === null ? 0 : $lastSibling->{static::POSITION} + 1);
        } elseif ($position > 0 && $to->hasChildren() === false) {
            $position = 0;
        }

        return $position;
    }

    protected function guessPositionOnCreate()
    {
        try {
            if ($this->count() > 0 && $this->hasSiblings()) {
                return $this->lastSibling()->{static::POSITION} + 1;
            } else {
                return 0;
            }
        } catch (\Exception $ex) {
            return 0;
        }
    }

    /**
     * Reorder all of the model siblings when it's moved.
     * When the model is moved from one subtree to another, its 'old' siblings are reordered as well.
     *
     * @param Entity $oldStateEntity
     * @return void
     */
    protected function reorderSiblings(Entity $oldStateEntity = null)
    {
        // 'oldStateEntity' is the entity in state when it hasn't been moved yet
        if ($oldStateEntity !== null && $oldStateEntity->hasSiblings()) {
            // the position at which the 'old' entity was
            $origpos = $oldStateEntity->getOriginal(static::POSITION);
            if ($this->{static::POSITION} != $origpos) {
                $keyName = $this->getKeyName();
                $siblingsIds = $this->buildSiblingsSubquery()
                    ->where($this->getQualifiedKeyName(), '<>', $this->getKey())
                    ->lists($keyName);
                $siblings = $this->whereIn($keyName, $siblingsIds);
                if ($this->{static::POSITION} > $origpos || ! $this->hasPrevSiblings()) {
                    $action = 'decrement';
                    $range = range($origpos, $this->{static::POSITION});
                } else {
                    $action = 'increment';
                    $range = range($this->{static::POSITION}, $origpos - 1);
                }
                $siblings->whereIn(static::POSITION, $range)->$action(static::POSITION);
                // here we reorder model's 'old' siblings
                $oldStateEntityDepth = $oldStateEntity->getDepth();
                if ($this->getDepth() != $oldStateEntityDepth) {
                    $nextIds = $oldStateEntity->nextSiblings()->lists($keyName);
                    $oldStateEntity->whereIn($keyName, $nextIds)->decrement(static::POSITION);
                }
            }
        }
    }

    /**
     * Perform a model insert operation.
     *
     * @param  \Illuminate\Database\Eloquent\Builder
     * @return bool
     */
    protected function performInsert(Builder $query)
    {
        if (parent::performInsert($query) === true) {
            $id = $this->getKey();
            $parent = $this->parent();
            $parentId = ($parent instanceof Entity ? $parent->getKey() : $id);
            $this->performInsertNode($id, $parentId);
            $this->setHidden($this->getClosureAttributes());

            return true;
        }

        return false;
    }

    /**
     * Perform a model update operation.
     *
     * @param  \Illuminate\Database\Eloquent\Builder
     * @return bool
     */
    protected function performUpdate(Builder $query)
    {
        $oldStateEntity = $this;
        if (parent::performUpdate($query) === true) {
            $this->setHidden($this->getClosureAttributes());
            $this->reorderSiblings($oldStateEntity);
        }
    }

    /**
     * Perform closure table rebuilding when the model's moved.
     *
     * @param Entity|null $ancestor
     * @return bool
     */
    protected function performMoveTo(Entity $ancestor = null)
    {
        $ak = static::ANCESTOR;
        $dk = static::DESCENDANT;
        $dpk = static::DEPTH;
        $ancestorValue = $this->getAncestor();
        // prevent constraint errors
        if ($ancestor !== null && $ancestorValue === $ancestor->getKey()) {
            return;
        }
        $descendantValue = $this->getKey();
        $closure = $this->getClosure();
        $ancestorsIds = DB::table($closure)
            ->where($dk, '=', $descendantValue)
            ->where($ak, '<>', $descendantValue)
            ->lists($ak);
        $descendantsIds = DB::table($closure)
            ->where($dk, '=', $descendantValue)
            ->lists($dk);
        if (count($ancestorsIds)) {
            DB::table($closure)
                ->whereIn($dk, $descendantsIds)
                ->whereIn($ak, $ancestorsIds)
                ->delete();
        }
        // null? make it root
        if ($ancestor === null) {
            return DB::table($closure)
                ->where(static::ANCESTOR, '=', $ancestorValue)
                ->where(static::DESCENDANT, '=', $descendantValue)
                ->update([
                    static::DEPTH => 0,
                    static::ANCESTOR => $descendantValue,
                ]);
        }
        $ancestorId = $ancestor->getKey();
        DB::transaction(function () use ($ak, $dk, $dpk, $closure, $ancestorId, $descendantValue) {
            $selectQuery = "
                SELECT supertbl.{$ak}, subtbl.{$dk}, supertbl.{$dpk}+subtbl.{$dpk}+1 as {$dpk}
                FROM {$closure} as supertbl
                CROSS JOIN {$closure} as subtbl
                WHERE supertbl.{$dk} = {$ancestorId}
                AND subtbl.{$ak} = {$descendantValue}
            ";
            $results = DB::select($selectQuery);
            array_walk($results, function (&$item) {
                $item = (array) $item;
            });
            DB::table($closure)->insert($results);
        });
    }

    /**
     * Perform closure table rebuilding when a new model is saved to the database.
     *
     * @param $descendant
     * @param $ancestor
     * @return mixed
     */
    protected function performInsertNode($descendant, $ancestor)
    {
        $table = $this->getClosure();
        $ak = static::ANCESTOR;
        $dk = static::DESCENDANT;
        $dpk = static::DEPTH;
        DB::transaction(function () use ($table, $ak, $dk, $dpk, $descendant, $ancestor) {
            $rawTable = DB::getTablePrefix().$table;
            $selectQuery = "
                SELECT tbl.{$ak} as {$ak}, {$descendant} as {$dk}, tbl.{$dpk}+1 as {$dpk}
                FROM {$rawTable} AS tbl
                WHERE tbl.{$dk} = {$ancestor}
                UNION ALL
                SELECT {$descendant}, {$descendant}, 0
            ";
            $results = DB::select($selectQuery);
            array_walk($results, function (&$item) {
                $item = (array) $item;
            });
            DB::table($table)->insert($results);
        });
    }

    /**
     * Delete the model, all related models and relationships in the closure table.
     *
     * @param bool $forceDelete
     * @return bool|null|void
     */
    public function deleteSubtree($forceDelete = true)
    {
        $ids = $this->buildDescendantsQuery()->lists($this->getKeyName());
        $ids[] = $this->getKey();
        $query = $this->whereIn($this->getKeyName(), $ids);

        return $forceDelete === true ? $query->forceDelete() : $query->delete();
    }

    protected function getPositionColumn()
    {
        return static::POSITION;
    }

    /**
     * Get the table qualified ancestor key name.
     *
     * @return string
     */
    protected function getQualifiedAncestorKeyName()
    {
        return $this->getClosure().'.'.static::ANCESTOR;
    }

    /**
     * Get the table qualified descendant key name.
     *
     * @return string
     */
    protected function getQualifiedDescendantKeyName()
    {
        return $this->getClosure().'.'.static::DESCENDANT;
    }

    /**
     * Get the table qualified depth key name.
     *
     * @return string
     */
    protected function getQualifiedDepthKeyName()
    {
        return $this->getClosure().'.'.static::DEPTH;
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new \Franzose\ClosureTable\Collection($models);
    }

    /**
     * Create a new model instance that is existing.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function newFromBuilder($attributes = [])
    {
        $instance = $this->newInstance([], true);
        $instance->setRawAttributes((array) $attributes, true);
        $instance->setHidden($instance->getClosureAttributes());

        return $instance;
    }
}

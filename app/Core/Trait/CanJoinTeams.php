<?php

namespace Orchid\Core\Models;

use Laravel\Spark\Events\User\JoinedTeam;
use Laravel\Spark\Spark;

trait CanJoinTeams
{
    /**
     * Get all of the teams that the user owns.
     */
    public function ownedTeams()
    {
        return $this->teams()->where('owner_id', $this->getKey());
    }

    /**
     * Get all of the teams that the user belongs to.
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'user_teams', 'user_id', 'team_id'
        )->withPivot(['role'])->orderBy('name', 'asc');
    }

    /**
     * Join the team with the given ID.
     *
     * @param int $teamId
     *
     * @return void
     */
    public function joinTeamById($teamId)
    {
        $this->teams()->attach([$teamId], ['role' => Spark::defaultRole()]);

        $this->currentTeam();

        event(new JoinedTeam($this, $this->teams()->find($teamId)));
    }

    /**
     * Get the team that user is currently viewing.
     *
     * @return \Illuminate\Database\Eloquent\Model|\Laravel\Spark\Teams\Team|null
     */
    public function currentTeam()
    {
        if (is_null($this->current_team_id) && $this->hasTeams()) {
            $this->switchToTeam($this->teams->first());

            return $this->currentTeam();
        } elseif (!is_null($this->current_team_id)) {
            $currentTeam = $this->teams->find($this->current_team_id);

            return $currentTeam ?: $this->refreshCurrentTeam();
        }
    }

    /**
     * Determine if the user is a member of any teams.
     *
     * @return bool
     */
    public function hasTeams()
    {
        return count($this->teams) > 0;
    }

    /**
     * Switch the current team for the user.
     *
     * @param \Laravel\Spark\Teams\Team $team
     *
     * @return void
     */
    public function switchToTeam($team)
    {
        $this->current_team_id = $team->id;

        $this->save();
    }

    /**
     * Refresh the current team for the user.
     *
     * @return \Illuminate\Database\Eloquent\Model|\Laravel\Spark\Teams\Team
     */
    public function refreshCurrentTeam()
    {
        $this->current_team_id = null;

        $this->save();

        return $this->currentTeam();
    }

    /**
     * Accessor for the currentTeam method.
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getCurrentTeamAttribute()
    {
        return $this->currentTeam();
    }

    /**
     * Determine if the given team is owned by the user.
     *
     * @param \Laravel\Spark\Teams\Team $team
     *
     * @return bool
     */
    public function ownsTeam($team)
    {
        if (is_null($team->owner_id) || is_null($this->id)) {
            return false;
        }

        return $this->id === $team->owner_id;
    }

    /**
     * Get the user's role on a given team.
     *
     * @param \Laravel\Spark\Teams\Team $team
     *
     * @return string
     */
    public function teamRole($team)
    {
        $team = $this->teams->find($team->id);

        if ($team) {
            return $team->pivot->role;
        }
    }

    /**
     * Get all of the pending invitations for the user.
     */
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}

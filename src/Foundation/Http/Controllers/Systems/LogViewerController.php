<?php

namespace Orchid\Foundation\Http\Controllers\Systems;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Orchid\LogViewer\LogViewer;
use App\Http\Controllers\Controller;
use Orchid\LogViewer\Tables\StatsTable;
use Illuminate\Pagination\LengthAwarePaginator;
use Orchid\LogViewer\Exceptions\LogNotFoundException;

class LogViewerController extends Controller
{
    /**
     * The log viewer instance.
     *
     * @var \Orchid\LogViewer\Contracts\LogViewer
     */
    protected $logViewer;

    /** @var int */
    protected $perPage = 30;

    /** @var string */
    protected $showRoute = 'log-viewer::logs.show';

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * LogViewerController constructor.
     */
    public function __construct(LogViewer $logViewer)
    {
        $this->logViewer = app('arcanedev.log-viewer');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * List all logs.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $stats = $this->logViewer->statsTable();
        $headers = $stats->header();
        $rows = $this->paginate($stats->rows(), $request);

        return view('dashboard::container.systems.logs.logs', compact('headers', 'rows', 'footer'));
    }


    /**
     * Show the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $stats = $this->logViewer->statsTable();
        $chartData = $this->prepareChartData($stats);
        $percents = $this->calcPercentages($stats->footer(), $stats->header());

        return view('dashboard::container.systems.logs.index', compact('chartData', 'percents'));
    }

    /**
     * Prepare chart data.
     *
     * @param  \Orchid\LogViewer\Tables\StatsTable $stats
     *
     * @return string
     */
    protected function prepareChartData(StatsTable $stats)
    {
        $totals = $stats->totals()->all();

        return json_encode([
            'labels' => Arr::pluck($totals, 'label'),
            'datasets' => [
                [
                    'data' => Arr::pluck($totals, 'value'),
                    'backgroundColor' => Arr::pluck($totals, 'color'),
                    'hoverBackgroundColor' => Arr::pluck($totals, 'highlight'),
                ],
            ],
        ]);
    }

    /**
     * Calculate the percentage.
     *
     * @param  array $total
     * @param  array $names
     *
     * @return array
     */
    protected function calcPercentages(array $total, array $names)
    {
        $percents = [];
        $all = Arr::get($total, 'all');

        foreach ($total as $level => $count) {
            $percents[$level] = [
                'name' => $names[$level],
                'count' => $count,
                'percent' => $all ? round(($count / $all) * 100, 2) : 0,
            ];
        }

        return $percents;
    }



    /**
     * Paginate logs.
     *
     * @param  array $data
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginate(array $data, Request $request)
    {
        $page = $request->get('page', 1);
        $offset = ($page * $this->perPage) - $this->perPage;
        $items = array_slice($data, $offset, $this->perPage, true);
        $rows = new LengthAwarePaginator($items, count($data), $this->perPage, $page);

        $rows->setPath($request->url());

        return $rows;
    }

    /**
     * Show the log.
     *
     * @param  string $date
     *
     * @return \Illuminate\View\View
     */
    public function show($date)
    {
        $log = $this->getLogOrFail($date);
        $levels = $this->logViewer->levelsNames();
        $entries = $log->entries()->paginate($this->perPage);

        return view('dashboard::container.systems.logs.show', compact('log', 'levels', 'entries'));
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Get a log or fail.
     *
     * @param  string $date
     *
     * @return \Orchid\LogViewer\Entities\Log|null
     */
    protected function getLogOrFail($date)
    {
        $log = null;

        try {
            $log = $this->logViewer->get($date);
        } catch (LogNotFoundException $e) {
            abort(404, $e->getMessage());
        }

        return $log;
    }

    /**
     * Filter the log entries by level.
     *
     * @param  string $date
     * @param  string $level
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showByLevel($date, $level)
    {
        $log = $this->getLogOrFail($date);

        if ($level === 'all') {
            return redirect()->route($this->showRoute, [$date]);
        }

        $levels = $this->logViewer->levelsNames();
        $entries = $this->logViewer
            ->entries($date, $level)
            ->paginate($this->perPage);

        return view('dashboard::container.systems.logs.show', compact('log', 'levels', 'entries'));
        // return $this->view('show', compact('log', 'levels', 'entries'));
    }

    /**
     * Download the log.
     *
     * @param  string $date
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($date)
    {
        return $this->logViewer->download($date);
    }

    /**
     * Delete a log.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        if (! $request->ajax()) {
            abort(405, 'Method Not Allowed');
        }

        $date = $request->get('date');

        return response()->json([
            'result' => $this->logViewer->delete($date) ? 'success' : 'error',
        ]);
    }
}

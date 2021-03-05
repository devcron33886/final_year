<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController
{
    public function index()
    {
        $users = [
            'chart_title'           => 'Total users',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\User',
            'group_by_field'        => 'email_verified_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
        ];

        $users['total_number'] = 0;

        if (class_exists($users['model'])) {
            $users['total_number'] = $users['model']::when(isset($users['filter_field']), function ($query) use ($users) {
                if (isset($users['filter_days'])) {
                    return $query->where(
                        $users['filter_field'],
                        '>=',
                        now()->subDays($users['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($users['filter_period'])) {
                    switch ($users['filter_period']) {
                        case 'week':
                            $start  = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start  = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($users['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$users['aggregate_function'] ?? 'count'}($users['aggregate_field'] ?? '*');
        }

        $houses = [
            'chart_title'           => 'Total Posts',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\House',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_days'           => '30',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
        ];

        $houses['total_number'] = 0;

        if (class_exists($houses['model'])) {
            $houses['total_number'] = $houses['model']::when(isset($houses['filter_field']), function ($query) use ($houses) {
                if (isset($houses['filter_days'])) {
                    return $query->where(
                        $houses['filter_field'],
                        '>=',
                        now()->subDays($houses['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($houses['filter_period'])) {
                    switch ($houses['filter_period']) {
                        case 'week':
                            $start  = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start  = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($houses['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$houses['aggregate_function'] ?? 'count'}($houses['aggregate_field'] ?? '*');
        }

        $house_charts = [
            'chart_title'           => 'House Chart',
            'chart_type'            => 'bar',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\House',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_days'           => '30',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-6',
            'entries_number'        => '5',
        ];

        $house_charts = new LaravelChart($house_charts);

        $bookings = [
            'chart_title'           => 'Total Booking',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Booking',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_days'           => '30',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
        ];

        $bookings['total_number'] = 0;

        if (class_exists($bookings['model'])) {
            $bookings['total_number'] = $bookings['model']::when(isset($bookings['filter_field']), function ($query) use ($bookings) {
                if (isset($bookings['filter_days'])) {
                    return $query->where(
                        $bookings['filter_field'],
                        '>=',
                        now()->subDays($bookings['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($bookings['filter_period'])) {
                    switch ($bookings['filter_period']) {
                        case 'week':
                            $start  = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start  = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($bookings['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$bookings['aggregate_function'] ?? 'count'}($bookings['aggregate_field'] ?? '*');
        }

        $subscribers = [
            'chart_title'           => 'Total subscribers',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Subscriber',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_days'           => '30',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
        ];

        $subscribers['total_number'] = 0;

        if (class_exists($subscribers['model'])) {
            $subscribers['total_number'] = $subscribers['model']::when(isset($subscribers['filter_field']), function ($query) use ($subscribers) {
                if (isset($subscribers['filter_days'])) {
                    return $query->where(
                        $subscribers['filter_field'],
                        '>=',
                        now()->subDays($subscribers['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($subscribers['filter_period'])) {
                    switch ($subscribers['filter_period']) {
                        case 'week':
                            $start  = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start  = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($subscribers['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$subscribers['aggregate_function'] ?? 'count'}($subscribers['aggregate_field'] ?? '*');
        }

        $tasks = [
            'chart_title'           => 'Tasks',
            'chart_type'            => 'line',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Task',
            'group_by_field'        => 'due_date',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_days'           => '7',
            'group_by_field_format' => 'Y-m-d',
            'column_class'          => 'col-md-6',
            'entries_number'        => '5',
        ];

        $tasks = new LaravelChart($tasks);

        $bookings_pie = [
            'chart_title'           => 'Booking Pie',
            'chart_type'            => 'pie',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Booking',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_days'           => '30',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-12',
            'entries_number'        => '5',
        ];

        $bookings_pie = new LaravelChart($bookings_pie);

        $latest_users = [
            'chart_title'           => 'LATEST USERS',
            'chart_type'            => 'latest_entries',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\User',
            'group_by_field'        => 'email_verified_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_days'           => '30',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-6',
            'entries_number'        => '5',
            'fields'                => [
                'name'     => '',
                'roles'    => 'title',
                'approved' => '',
            ],
        ];

        $latest_users['data'] = [];

        if (class_exists($latest_users['model'])) {
            $latest_users['data'] = $latest_users['model']::latest()
                ->take($latest_users['entries_number'])
                ->get();
        }

        if (!array_key_exists('fields', $latest_users)) {
            $latest_users['fields'] = [];
        }

        $latest_tasks = [
            'chart_title'           => 'Tasks To Do',
            'chart_type'            => 'latest_entries',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Task',
            'group_by_field'        => 'due_date',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_days'           => '7',
            'group_by_field_format' => 'Y-m-d',
            'entries_number'        => '5',
            'fields'                => [
                'name'   => '',
                'status' => 'name',
                'tag'    => 'name',
            ],
        ];

        $latest_tasks['data'] = [];

        if (class_exists($latest_tasks['model'])) {
            $latest_tasks['data'] = $latest_tasks['model']::latest()
                ->take($latest_tasks['entries_number'])
                ->get();
        }

        if (!array_key_exists('fields', $latest_tasks)) {
            $latest_tasks['fields'] = [];
        }

        $events=Task::whereNotNull('due_date')->get();

        return view('home', compact('users', 'houses', 'bookings', 'bookings_pie',
            'house_charts', 'latest_users', 'latest_tasks', 'subscribers', 'tasks','events'));
    }
}

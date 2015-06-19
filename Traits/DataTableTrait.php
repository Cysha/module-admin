<?php namespace Cms\Modules\Admin\Traits;

use Cms\Modules\Admin\Events\GotDatatableConfig;
use yajra\Datatables\Engine\CollectionEngine;
use yajra\Datatables\Facades\Datatables;

trait DataTableTrait
{
    private $collection = null;
    private $columns    = [];
    private $pagination = true;
    private $filtering  = true;
    private $sorting    = true;
    private $options    = [];

    public function renderDataTable($tableConfig)
    {
        if (empty($tableConfig)) {
            throw new \Exception('Could not load datatable configuration.');
        }

        // add a temp legacy mode for the config versions
        if (is_string($tableConfig)) {
            $tableConfig = config($tableConfig);
        }

        // see if there is an update for this table
        $update = event(new GotDatatableConfig($tableConfig));

        // clear any empty updates
        $update = array_filter($update);

        // if we have any updates, replace them into the config
        if (count($update)) {
            foreach ($update as $update) {
                $tableConfig = array_replace($tableConfig, $update);
            }
        }

        // PROCESS MY PRETTIES :D
        if (($arr = array_get($tableConfig, 'page.title', null)) !== null) {
            $this->theme->setTitle($arr);
        }
        if (($arr = array_get($tableConfig, 'page.header', null)) !== null) {
            $this->setActions(['header' => $arr]);
        }
        if (($arr = array_get($tableConfig, 'options', null)) !== null) {
            $this->setTableOptions($arr);
        }
        if (($arr = array_get($tableConfig, 'columns', null)) !== null) {
            $this->setTableColumns($arr);
        }

        // share some infos
        view()->share('tableConfig', $tableConfig);
        view()->share('tableOptions', $this->options);

        // if its for the data, output now
        if (\Request::ajax()) {
            return $this->getDataTableJson();
        }

        // otherwise output the table
        $data = $this->getDataTableData();

        return $this->getDataTableHtml($data);
    }

    public function assets()
    {
        $protocol = \Request::secure() ? 'https' : 'http';

        $this->theme->asset()->add('datatable-js', $protocol.'://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js', array('app.js'));
        $this->theme->asset()->add('datatable-bs-js', $protocol.'://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js', array('datatable-js'));

        $this->theme->asset()->add('datatable-bs-css', $protocol.'://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css', array('bootstrap'));
        $this->theme->asset()->add('datatable-fa-css', $protocol.'://cdn.datatables.net/plug-ins/725b2a2115b/integration/font-awesome/dataTables.fontAwesome.css', array('bootstrap-bs-css'));
        //$this->theme->asset()->add('datatable-viewcss', 'packages/modules/admin/css/admin.datatable-view.css', array('datatable-css'));
    }

    private function getDataTableHtml($data)
    {
        return $this->setView('admin.datatable.index', $data, 'module:admin');
    }

    private function getDataTableData()
    {
        $this->assets();
        $data = [];

        $data['columns'] = $this->getColumns();

        $data['filterOptions'] = array_filter($this->getColumns(), function ($row) {
            if (isset($row['filtering']) && $row['filtering'] === true) {
                return true;
            }
            return false;
        });

        $data['options'] = json_encode($this->options ?: []);

        return $data;
    }

    private function getDataTableJson()
    {
        $table = Datatables::of($this->collection);
        $columns = $this->getColumns();

        // process columns
        foreach ($columns as $key => $column) {
            $value = array_get($column, 'tr', null);

            if ($key === 'actions' && !empty($value)) {
                $table->addColumn($key, function ($model) use ($value) {
                    return $this->buildActionButtons($value, $model);
                });
                continue;
            }

            if (is_callable($value)) {
                $table->editColumn($key, $value);
            }
        }

        if (array_get($this->options, 'searching', false) !== false) {
            $request = app('request');
            $table->filter(function ($instance) use ($request, $columns) {
                foreach ($columns as $key => $column) {
                    if (array_get($column, 'searchable', false) === false) {
                        continue;
                    }
                    \Debug::console('searchable - '.$key);
                    if ($request->has($key)) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request, $key) {
                            return str_contains($row[$key], $request->get($key)) ? true : false;
                        });
                    }
                }
            });
        }

        return $table->make(true);
    }

/** Getters **/
    private function getColumns()
    {
        return array_filter($this->columns, function ($row) {
            if (!isset($row['tr']) || $row['tr'] === false) {
                return false;
            }
            return true;
        });
    }

    private function buildActionButtons(callable $buttons, $model)
    {
        $actionColumn = [];

        foreach ($buttons($model) as $btn) {

            if (isset($btn['btn-text'])) {
                $tpl = '<span class="btn-label"><i class="%s fa-fw"></i></span> <span>%s</span>';
                $label = sprintf($tpl, array_get($btn, 'btn-icon'), array_get($btn, 'btn-text', null));

            } elseif (isset($btn['btn-title'])) {
                $tpl = '<span title="%2$s" data-toggle="tooltip"><i class="%1$s fa-fw"></i></span>';
                $label = sprintf($tpl, array_get($btn, 'btn-icon'), array_get($btn, 'btn-title', null));

            } else {
                $tpl = '<i class="%s fa-fw"></i>';
                $label = sprintf($tpl, array_get($btn, 'btn-icon'));
            }

            $tpl = '<a class="%s" href="%s">%s</a>';
            $actionColumn[] = sprintf($tpl, array_get($btn, 'btn-class'), array_get($btn, 'btn-link', '#'), $label);
        }

        return implode('&nbsp;', $actionColumn);
    }

/** Setters **/
    private function setTableOptions(array $options)
    {
        // assign collection
        $value = array_pull($options, 'collection', null);
        if ($value !== null) {
            $this->setCollection($value);
        }

        $value = array_pull($options, 'source', null);
        if ($value !== null) {
            $this->setOption('ajax', route($value));
        } else {
            $this->setOption('ajax', \Request::url());
        }

        $this->setOption('processing', true);
        $this->setOption('serverSide', true);

        // assign the rest of the things
        foreach ($options as $key => $value) {
            $this->setOption($key, $value);
        }
    }

    private function setTableColumns(array $value)
    {
        $this->columns = $value;

        $this->setOption('columns', []);

        // loop through the columns we have and assign them to the table
        $counter = 0;
        foreach ($this->columns as $key => $column) {

            if ($this->options['sort_column'] == $key) {
                $this->setOption('order', [[$counter, array_get($this->options, 'sort_order', 'desc')]]);
            }

            array_set($this->options, 'columns.'.$counter, [
                'data' => $key,
            ]);

            if ($key !== 'actions') {
                $value = array_get($column, 'tr', null);
                $visible = is_callable($value) ? true : false;
                $orderable = array_get($column, 'orderable', false);
                $searchable = array_get($column, 'searchable', false);

                array_set($this->options, 'columnDefs', [[
                    'targets' => [ $counter ],
                    'visible' => $visible === true ? 'true' : 'false',
                    'orderable' => $orderable === true ? 'true' : 'false',
                    'searchable' => $searchable === true ? 'true' : 'false',
                ]]);
            }

            $counter++;
        }

    }

    private function setCollection(callable $closure)
    {
        $this->collection = $closure();
    }

    private function setOption($key, $value)
    {
        $this->options[$key] = $value;
    }

}

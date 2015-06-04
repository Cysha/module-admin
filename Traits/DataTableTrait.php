<?php namespace Cms\Modules\Admin\Traits;

use Cms\Modules\Admin\Events\GotDatatableConfig;
use Datatable;

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

        // clear any empty ones
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

        $this->theme->asset()->add('datatable-js', $protocol.'://cdn.datatables.net/1.9.4/js/jquery.dataTables.js', array('app.js'));
        $this->theme->asset()->add('datatable-bs-js', $protocol.'://cdn.datatables.net/plug-ins/fcd3b3cf0d/integration/bootstrap/3/dataTables.bootstrap.js', array('datatable-js'));

        $this->theme->asset()->add('datatable-bs-css', $protocol.'://cdn.datatables.net/plug-ins/fcd3b3cf0d/integration/bootstrap/3/dataTables.bootstrap.css', array('bootstrap'));
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

        $data['options'] = $this->options ?: [];

        return $data;
    }

    private function getDataTableJson()
    {
        $table = Datatable::collection($this->collection);

        $columns = $this->getColumns();

        $options = [
            'show' => [],
            'search' => [],
            'order' => [],
        ];

        // loop through the columns we have and assign them to the table
        foreach ($columns as $key => $column) {
            $value = array_get($column, 'tr', null);

            if ($key === 'actions' && !empty($value)) {
                $table->addColumn($key, function ($model) use ($value) {
                    return $this->buildActionButtons($value, $model);
                });
                continue;
            }

            if (is_callable($value)) {
                $table->addColumn($key, $value);
            } else {
                $options['show'][] = $key;
            }

            if (array_get($column, 'sorting', false) === true) {
                $options['order'][] = $key;
            }

            if (array_get($column, 'filtering', false) === true) {
                $options['search'][] = $key;
            }
        }

        // make sure any options get set properly
        count($options['show']) && call_user_func_array([$table, 'showColumns'], array_get($options, 'show', []));
        count($options['search']) && call_user_func_array([$table, 'searchColumns'], array_get($options, 'search', []));
        count($options['order']) && call_user_func_array([$table, 'orderColumns'], array_get($options, 'order', []));

        $table->setAliasMapping();
        return $table->make();
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
            $this->setOption('source', route($value));
        } else {
            $this->setOption('source', \Request::url());
        }

        // assign the rest of the things
        foreach ($options as $key => $value) {
            $this->setOption($key, $value);
        }
    }

    private function setTableColumns(array $value)
    {
        $this->columns = $value;
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

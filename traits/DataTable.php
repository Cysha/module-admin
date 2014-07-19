<?php namespace Cysha\Modules\Admin\Traits;

trait DataTable{

    private $collection = null;
    private $columns    = array();
    private $pagination = true;
    private $filtering  = true;
    private $sorting    = true;
    private $options    = array();

    public function assets(){
        $this->theme->asset()->serve('datagrid');
        $this->theme->asset()->add('datagrid-view', 'packages/modules/shop/css/admin.datagrid-view.css', array('base'));
    }

    public function getDataTableIndex() {
        $columns = array_filter($this->getColumns(), function($row){
            if( !isset($row['tr']) || $row['tr'] === false ){
                return false;
            }
            return true;
        });

        $filterOptions = array_filter($this->getColumns(), function($row){
            if( isset($row['filtering']) && $row['filtering'] === true ){
                return true;
            }
            return false;
        });

        $options = $this->options ?: array();

        return $this->setView('datatables.index', compact('columns', 'options', 'filterOptions'), 'module:admin');
    }

    public function getDataTableJson(){
        $collection = $this->collection;

        $columns = $this->getColumns(); $dataColumns = array();
        foreach($columns as $key => $column){
            if( isset($column['alias']) && $column['alias'] !== $key ){
                $dataColumns[ $key ] = $column['alias'];
            }else{
                $dataColumns[] = $key;
            }
        }

        return \DataGrid::make($collection, $dataColumns);
    }

/** Getters **/
    private function getColumns(){
        return $this->columns;
    }

/** Setters **/
    private function setTableOptions(array $options){
        // assign collection
        $value = array_pull($options, 'collection', null);
        if( $value !== null ){
            $this->setCollection($value);
        }

        // assign the rest of the things
        foreach( $options as $key => $value){
            $this->setOption($key, $value);
        }
    }

    private function setTableColumns(array $value){
        $this->columns = $value;
    }

    private function setCollection(callable $closure){
        $this->collection = $closure();
    }

    private function setOption($key, $value){
        $this->options[$key] = $value;
    }

}
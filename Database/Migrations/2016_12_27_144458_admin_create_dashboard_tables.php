<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminCreateDashboardTables extends Migration
{
    public function __construct()
    {
        // Get the prefix
        $this->prefix = config('cms.admin.config.table-prefix', 'admin_');
    }

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->prefix.'dashboard_widgets', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('component');
            $table->string('grid')->nullable();
        });

        Schema::create($this->prefix.'dashboard_widget_options', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('dashboard_widget_id')->unsigned();
            $table->string('key');
            $table->string('value')->nullable();

            $table->unique(['dashboard_widget_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop($this->prefix.'dashboard_widget_options');
        Schema::drop($this->prefix.'dashboard_widgets');
    }
}

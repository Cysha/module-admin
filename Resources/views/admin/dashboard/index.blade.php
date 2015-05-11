<div class="row">
    <div class="col-md-12">
        <a class="btn btn-default pull-right" id="edit-grid" data-mode="0" href="#">Edit Grid</a>
        <a class="btn btn-default pull-right" id="add-widget" data-toggle="modal" data-target="#myModal">Add Widget</a>
    </div>
</div>
<div class="row">
    <div class="grid-stack" data-gs-width="12">
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add widget to dashboard</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                {{ Former::open(URL::route('admin.dashboard.widget')) }}
                    {{ Former::select('widget', 'Choose Widget')->options(['x' => 'Choose a widget']+$widgetList)->default('x') }}
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Add Widget & Close</button>
                {{ Former::close() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(function () {
    var options = {
        cell_height: 60,
        vertical_margin: 10
    };
    jQuery('.grid-stack').gridstack(options);

    /** savey crap */
    dashboard = new function () {
        this.serialized_data = {{ (($gridData = Config::get('admin::dashboard.grid')) !== null ? $gridData : '{}') }};

        this.grid = jQuery('.grid-stack').data('gridstack');

        this.load_grid = function () {
            this.grid.remove_all();
            var items = GridStackUI.Utils.sort(this.serialized_data);
            _.each(items, function (node) {
                this.spawn_widget(node);
                jQuery(jQuery.find('option[value="'+node.id+'"]')[0]).hide();
            }, this);
        }.bind(this);

        this.save_grid = function () {
            this.serialized_data = _.map($('.grid-stack > .grid-stack-item:visible'), function (el) {
                el = jQuery(el);
                var node = el.data('_gridstack_node');

                return {
                    id: el.attr('id'),
                    x: node.x,
                    y: node.y,
                    width: node.width,
                    height: node.height
                };
            }, this);
            jQuery.post("{{ URL::route('admin.dashboard.savegrid') }}", {
                grid: JSON.stringify(this.serialized_data)
            });
        }.bind(this);

        this.clear_grid = function () {
            this.grid.remove_all();
            jQuery(jQuery.find('option:hidden')).show();
        }.bind(this);

        this.edit_grid = function () {
            mode = jQuery('#edit-grid').data('mode');

            if (mode == 0) {

                // enable all the grid editing
                _.map(jQuery('.grid-stack > .grid-stack-item:visible'), function (el) {
                    this.grid.movable(el, true);
                    jQuery(el).on('dblclick', function (e) {
                        this.grid.resizable(el, true);
                    }.bind(this));
                }, this);
                jQuery('#edit-grid').data('mode', 1).text('Save Grid');

            } else {

                // disable all the grid editing
                _.map(jQuery('.grid-stack > .grid-stack-item:visible'), function (el) {
                    this.grid.movable(el, false);
                    this.grid.resizable(el, false);
                    jQuery(el).off('dblclick');
                }, this);
                jQuery('#edit-grid').data('mode', 0).text('Edit Grid');

                // run the save mech
                this.save_grid();
            }
        }.bind(this);

        this.spawn_widget = function (node) {
            element = jQuery('<div><div class="grid-stack-item-content" /><div/>');

            this.grid.add_widget(element, node.x, node.y, node.width, node.height, node.auto_position);

            if (!node.id.length) {
                return;
            }
            element.attr({id: node.id});
            this.grid.resizable(element, false);
            this.grid.movable(element, false);

            this.load_data(node.id, element.find('.grid-stack-item-content'));

            return element;
        }.bind(this);

        this.load_data = function (id, element) {
            console.log(['loading', id]);
            jQuery.ajax({
                type: "POST",
                url: '{{ URL::route('admin.dashboard.widget') }}',
                data: {widget: id},
                success: function (data) {
                    jQuery(element).html(data);
                }
            });

        }.bind(this);

        jQuery('#edit-grid').click(this.edit_grid);

        jQuery('#myModal').on('hidden.bs.modal', function (e) {
            value = jQuery('select[name=widget]').val();
            if (value == 'x') {
                return;
            }
            element = this.spawn_widget({
                auto_position: true,
                width: 2,
                height: 2,
                id: value
            });
            this.grid.resizable(element, true);
            this.grid.movable(element, true);

        }.bind(this));
        this.load_grid();
    };


});
</script>

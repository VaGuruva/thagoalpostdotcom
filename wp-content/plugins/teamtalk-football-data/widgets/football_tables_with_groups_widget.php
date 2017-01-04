<?php

class football_tables_with_groups_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'football_tables_with_groups_widget', // Base ID
                'Football Tables with Groups Widget ', array('description' => 'Football: Football Tables with Groups Widget ') // Args
        );
    }

    public function widget($args, $instance) {
        ?>

        <style>
            .fa {
                display: block !important;
                border: 0px !important;

            }
            .ranking-yrchg-up {
                color: #00a753;
                padding-right: 5px;
            }

            .ranking-yrchg-down {
                color: #ff002b;
                padding-right: 5px;
            }
        </style>

        <?php
        $slug = get_category_slug(!empty($args["is_team"]) ? 4 : 3);

        $competition_logs = array();
        $football_data = new Football_Data();
        //$competition_id = get_competition_id();
        //$competition_id = get_field_id($slug, !empty($args["is_team"]));

        $slug = get_category_slug(4);
        $parts = explode('/', $slug);
        $slug = $parts[4];

        if ($slug == 'premier-league') {
            $competition_id = 9;
        } else {
            $competition_id = get_competition_id();
        }

        $competition = $football_data->competitions_by_data(array(
            "id" => $competition_id,
        ));

        if (!empty($competition)) {
            $competition_logs = $football_data->logs_by_data(array(
                "competition_id" => $competition->competition_id,
                "season_id" => $competition->season_id
            ));
        }
        ?>

        <?php if (empty($args["is_team"])): ?>
            <?php if (!empty($competition->season_name)): ?>
                <!-- Big Table Container -->
                <header class="articleList__header tables-header">
                    <h3><?php echo $competition->competition_name ?> <?php echo str_replace("Season ", "", $competition->season_name) ?></h3>
                </header>
            <?php endif; ?>
        <?php else: ?>
            <?php $team_id = get_team_id($slug);  ?>
        <?php endif; ?>

        <div class="article article-table">
            <!-- Widget Display -->
            <section>
                <table class="tables-table" cellpadding="10" cellspacing="10">
                    <tr class="tables-table-header">
                        <th>POS</th>
                        <th class="hidden-xs">&nbsp;</th>
                        <th class="hidden-xs">LP</th>
                        <th class="table-club">CLUB</th>
                        <th>P</th>
                        <th>W</th>
                        <th>D</th>
                        <th>L</th>
                        <th class="hidden-xs">GF</th>
                        <th class="hidden-xs">GA</th>
                        <th class="hidden-xs">GD</th>
                        <th>PTS</th>
                    </tr>
                    <?php foreach ($competition_logs as $log): ?>
                        <tr class="<?php echo!empty($args["is_team"]) && $team_id == $log->team->id ? "pl-current" : "" ?>">
                            <td><?php echo $log->position ?></td>
                            <?php if ($log->position > $log->previous_position):?>
                                <td class="fa fa-caret-down ranking-yrchg-down"></td>
                            <?php endif; ?>

                            <?php if ($log->position < $log->previous_position):?>
                                <td class="fa fa-caret-up ranking-yrchg-up"></td>
                            <?php endif; ?>

                            <?php if ($log->position == $log->previous_position):?>
                                <td class=" hidden-xs">-</td>
                            <?php endif; ?>
                            <td class="hidden-xs"><?php echo $log->previous_position ?></td>
                            <td class="table-club"><?php echo $log->team->team_name ?></td>
                            <td><?php echo $log->played ?></td>
                            <td><?php echo $log->won ?></td>
                            <td><?php echo $log->drawn ?></td>
                            <td><?php echo $log->lost ?></td>
                            <td class="hidden-xs"><?php echo $log->fors ?></td>
                            <td class="hidden-xs"><?php echo $log->against ?></td>
                            <td class="hidden-xs"><?php echo $log->fors - $log->against ?></td>
                            <td><?php echo $log->points ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (count($competition_logs) == 0): ?>
                        <tr>
                            <td colspan="12">There are currently no log data available for this this competition</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </section>
        </div>
        <?php
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('New title', 'text_domain');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }

}

add_action('widgets_init', function() {
    register_widget('football_tables_with_groups_widget');
});
?>

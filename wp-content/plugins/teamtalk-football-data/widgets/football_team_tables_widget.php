<?php

class football_team_tables_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'football_team_tables_widget',
                'Football Team Tables Widget', array('description' => 'Football: Football Team Tables Widget')
        );
    }

    public function widget($args, $instance) {
        ?>
        <?php

        $url = $_SERVER['REQUEST_URI'];
        $url_lower_case = strtolower(str_replace("-", " ", $url));

        $competition_logs = array();
        $football_data = new Football_Data();

        $slug = get_category_slug(4);
        $parts = explode('/', $slug);
        $slug = $parts[4];

        if ($slug == 'premier-league') {
            $competition_id = 63;
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

        <div class="article football-fixtures-results">
            <header class="articleList__header">
                <h3>Log</h3>
            </header>

            <div class="standings-item">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>POS</th>
                            <th>&nbsp;</th>
                            <th class="team-name">Team</th>
                            <th class="p">P</th>
                            <th class="w">W</th>
                            <th class="d">D</th>
                            <th class="l">L</th>
                            <th class="gf">GF</th>
                            <th class="ga">GA</th>
                            <th class="gd">GD</th>
                            <th class="pts">Pts</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($competition_logs as $log): ?>
                    <?php  $team_id = $log->team->id; ?>
                    <?php if (strpos($url_lower_case, strtolower($log->team->team_name)) !== false){ ?>
                        <tr class="team-current">
                    <?php } ?>
                    <?php if (strpos($url_lower_case, strtolower($log->team->team_name)) === false){ ?>
                        <tr>
                    <?php } ?>
                            <td class="pos"><?php echo $log->position ?></td>
                            <td class="team-logo"><img src="<?php echo get_template_directory_uri();?><?php echo"/images/teamlogos/$team_id.png" ?>"</td>
                            <td class="team-name"><?php echo $log->team->team_name ?></td>
                            <td class="p"><?php echo $log->played ?></td>
                            <td class="w"><?php echo $log->won ?></td>
                            <td class="d"><?php echo $log->drawn ?></td>
                            <td class="l"><?php echo $log->lost ?></td>
                            <td class="gf"><?php echo $log->fors ?></td>
                            <td class="ga"><?php echo $log->against ?></td>
                            <td class="gd"><?php echo $log->fors - $log->against ?></td>
                            <td class="pts"><?php echo $log->points ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if (count($competition_logs) == 0): ?>
                <tr>
                    <td colspan="12">There is currently no log data available for this competition for this season.</td>
                </tr>
            <?php endif; ?>
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
    register_widget('football_team_tables_widget');
});
?>

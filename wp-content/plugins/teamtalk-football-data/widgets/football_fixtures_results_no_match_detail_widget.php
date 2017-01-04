<?php

class football_fixtures_results_no_match_detail_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'football_fixtures_results_no_match_detail_widget', // Base ID
                '[Comp] Fixture & Results with No Match Detail Widget', // Name
                array('description' => 'This is the Competition Fixture & Results with NO Match Detail Widget',) // Args
        );
    }

    public function widget($args, $instance) {
        $football_data = new Football_Data();
        //$competition_id = 9;//get_field_id();
        $competition_id = get_competition_id();

        if (!empty($competition_id)) {
            $competition_fixtures = $football_data->fixtures_by_data(array(
                "competition_id" => $competition_id,
                "days" => 365,
                "has_results" => true
            ));
        }
        ?>

        <header class="articleList__header tables-header">
            <h3>Fixtures & Results</h3>
        </header>

        <div class="article article-table">
            <!-- Fixtures -->
            <?php $fixtures_handle = array(); ?>
            <?php foreach ($competition_fixtures as $fixture): ?>
                <?php $fixtures_handle[date("l j F Y", strtotime($fixture->fixture_date_time))][] = $fixture; ?>
            <?php endforeach; ?>

            <!-- Fixtures & Results Data - Day 1 -->
            <?php foreach ($fixtures_handle as $key => $fixtures): ?>
                <table class="fixtures-table" cellpadding="10" cellspacing="10">
                    <tr class="fixtures-table-header">
                        <th colspan="7"><?php echo $key ?></th>
                    </tr>
                    <?php foreach ($fixtures as $fixture): ?>
                        <?php //$fixture_date_time = strtotime($fixture->fixture_date_time) ?>
                        <?php
                        date_default_timezone_set('Europe/London');
                        $datetime = new DateTime($fixture->fixture_date_time);
                        $datetime->format('Y-m-d H:i:s') . "\n";
                        $la_time = new DateTimeZone('Africa/Johannesburg');
                        $datetime->setTimezone($la_time);
                        $fixture_date_time = strtotime($datetime->format('Y-m-d H:i:s'));
                        ?>
                        <?php $home_team = $fixture->home->team_name ?>
                        <?php $away_team = $fixture->away->team_name ?>
                        <?php $result = $fixture->result ?>
                        <?php if ($fixture_date_time > time()): ?>
                            <?php $result = array(); ?>
                        <?php endif; ?>
                        <tr <?php echo $fixture->fixture_id ?>>
                            <td>&nbsp;</td>
                            <td><?php echo date("H:i", $fixture_date_time) ?></td>
                            <td><?php echo trim_string($fixture->competition_name) ?></td>
                            <td><?php echo $home_team ?></td>
                            <td>
                                <?php if (!empty($result)): ?>
                                    <?php $match_result = $result->home_final_score . " - " . $result->away_final_score ?>
                                    <?php if (strtotime("29/08/2015") >= strtotime($fixture_date_time)): ?>
                                        <?php $match = sanitize_title_for_query($home_team) . "-vs-" . sanitize_title_for_query($away_team); ?>
<!--                                        <a href="--><?php //echo site_url() ?><!--/match/--><?php //echo $match ?><!--/--><?php //echo $fixture->fixture_id ?><!--">-->
                                            <?php echo $match_result ?>
<!--                                        </a>-->
                                    <?php else: ?>
                                        <?php $match = sanitize_title_for_query($home_team) . "-vs-" . sanitize_title_for_query($away_team); ?>
<!--                                        <a href="--><?php //echo site_url() ?><!--/match/--><?php //echo $match ?><!--/--><?php //echo $fixture->fixture_id ?><!--">-->
                                            <?php echo $match_result ?>
<!--                                        </a>-->
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span>-</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $away_team ?></td>
                            <td>&nbsp;</td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endforeach; ?>
            <!-- End Fixtures & Results Data - Day 1-->
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

add_action('widgets_init', function () {
    register_widget('football_fixtures_results_no_match_detail_widget');
});
?>
<?php

class data_team_squad_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'data_team_squad_widget', // Base ID
                'Team Squad Widget', // Name
                array('description' => 'Team Squad Widget',) // Args
        );
    }

    public function widget($args, $instance) {
        $team_squad = array();
        $football_data = new Football_Data();

        $slug = get_category_slug(4);
        $team_id = get_field_id($slug);

        if (!empty($team_id)) {
            $team_squad = $football_data->teams_by_data(array(
                "team_id" => $team_id,
                "section" => "players"
            ));
        }
        ?>

        <?php if (!empty($team_squad->players)): ?>
            <header class="articleList__header">
                <h3><?php echo $team_squad->team_name ?> Squad Players</h3>
            </header>
            <div class="article">
                <div class="row">
                    <div class="col-md-2 col-sm-12"><span><strong>Goalkeepers</strong></span>
                        <ul>
                            <?php foreach ($team_squad->players as $key => $player): ?>
                                <?php if ($player->position == "Goalkeeper"): ?>
                                    <li>
                                        <!--<strong><?php echo $key ?></strong>-->
                                        <span class="squad_name">
                                            <?php echo $player->first_name ?>
                                            <?php echo $player->last_name ?>
                                        </span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-12"><span><strong>Defenders</strong></span>
                        <ul>
                            <?php foreach ($team_squad->players as $key => $player): ?>
                                <?php if (in_array($player->position, array("Central Defender", "Full Back"))): ?>
                                    <li>
                                        <!--<strong><?php echo $key ?></strong>-->
                                        <span class="squad_name">
                                            <?php echo $player->first_name ?>
                                            <?php echo $player->last_name ?>
                                        </span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-12"><span><strong>Midfielders</strong></span>
                        <ul>
                            <?php foreach ($team_squad->players as $key => $player): ?>
                                <?php if (in_array($player->position, array("Defensive Midfielder", "Central Midfielder"))): ?>
                                    <li>
                                        <!--<strong><?php echo $key ?></strong>-->
                                        <span class="squad_name">
                                            <?php echo $player->first_name ?>
                                            <?php echo $player->last_name ?>
                                        </span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-12"><span><strong>Attacking Midfielders</strong></span>
                        <ul>
                            <?php foreach ($team_squad->players as $key => $player): ?>
                                <?php if ($player->position == "Attacking Midfielder"): ?>
                                    <li>
                                        <!--<strong><?php echo $key ?></strong>-->
                                        <span class="squad_name">
                                            <?php echo $player->first_name ?>
                                            <?php echo $player->last_name ?>
                                        </span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-12 "><span><strong>Forwards</strong></span>
                        <ul>
                            <?php foreach ($team_squad->players as $key => $player): ?>
                                <?php if (in_array($player->position, array("Winger", "Striker", "Second Striker"))): ?>
                                    <li>
                                        <!--<strong><?php echo $key ?></strong>-->
                                        <span class="squad_name">
                                            <?php echo $player->first_name ?>
                                            <?php echo $player->last_name ?>
                                        </span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
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
    register_widget('data_team_squad_widget');
});
?>
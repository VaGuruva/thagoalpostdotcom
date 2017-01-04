$(document).ready(function(){
    var $move_left = $('#score_container .move_left');
    var $move_right = $('#score_container .move_right');
    var $display = $('#score_container .score_display');
    var half_display_width = $display.width() / 2;
    var $score_list = $('#score_container .score_display ul');
    var score_list_width = $score_list.width();
    var $score_tabs = $('#score_container .score_tabs li');
    var current_pos = 0;
    var touch,startX,startY,endLeft = 0;
    var init = false, dragging = false;
    var timer_id = 0, move_direction = 1, moving = false;

    /* Used to move position of score display */
    function moveScoreDisplay(position, quick){
        if (quick){
            $display.scrollLeft(position);
        }
        else{
            $display.animate({scrollLeft: position + 'px'}, 400);
        }
    }

    /* Used to control auto movement of score display, direction usage: 1 (right) or -1 (left) */
    function autoMove(direction){
        moving = true;
        if ((direction == 1)&&(current_pos == score_list_width - half_display_width * 2)){
            move_direction = -1;
            timer_id = setTimeout(function(){
                autoMove(move_direction);
            },3000);
            return;
        }
        else if ((direction == -1)&&(current_pos === 0)){
            move_direction = 1;
            timer_id = setTimeout(function(){
                autoMove(move_direction);
            },3000);
            return;
        }
        else{
            current_pos = current_pos + direction * 100;

            if ((score_list_width - current_pos) <= (half_display_width * 2)){
                current_pos = score_list_width - half_display_width * 2;
            }
            if (current_pos <= 0){
                current_pos = 0;
            }

            $display.animate({scrollLeft: current_pos + 'px'}, 4000, 'linear');
            timer_id = setTimeout(function(){
                autoMove(direction);
            },4000);
        }
    }

    /* Used to change content of score list when user chooses different tabs */
    function loadScoreTab(url, type, link){

        $display.stop(true, false).find('ul').css('display', 'none');
        $display.find('#loading_icon').css('display', 'block');
        clearTimeout(timer_id);
        current_pos = 0;
        moveScoreDisplay(current_pos, true);
        move_direction = 1;
        moving = true;	// (intentional) to prevent moving while loading result is not finished

        /* Fetch results from url */
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'xml',
            success: function(xml){
                switch(type){
                    case 'football':
                        processFootballResults(xml, link);
                        break;
                    case 'rugby':
                        processRugbyResults(xml, link);
                        break;
                    case 'cricket':
                        processCricketResults(xml);
                        break;
                    default:
                        break;
                }
            },
            error: function(err){
                console.log(err);
            }
        });
    }

    /* Process XML Data for Football, Rugby & Cricket */

    /* Process xml data for Football */
    function processFootballResults(xml, link){
        var $data = $(xml);
        var output = '';
        var time, comp_id, h_team, h_team_id, a_team, a_team_id, result_home, result_away, comp_name, base_football_url;

        $data.find('details item').each(function(idx, obj){
            time = '<p class="time">' + moment($(obj).find('datetime').text()).format('DD MMM') + '</p>';
            comp_id = $(obj).find('comp-id').text();
            comp_name = $(obj).find('comp-name').text();
            h_team = $(obj).find('home-team').text();
            h_team_id = $(obj).find('home-team-id').text();
            a_team = $(obj).find('away-team').text();
            a_team_id = $(obj).find('away-team-id').text();
            result_home = $(obj).find('result-home').text();
            result_away = $(obj).find('result-away').text();
            status 	= $(obj).find('status').text();

            if (result_home == '') {
                result_home = '&nbsp;';
            }
            if (result_away == '') {
                result_away = '&nbsp;';
            }

            var site_base_url =  window.location.origin;
            console.log(site_base_url);

            if (comp_id == 9) {
                base_football_url = site_base_url + '/football/europe/england/premier-league/';
            }

            if (comp_id == 76) {
                base_football_url = site_base_url + '/football/europe/spain/spanish-la-liga/';
            }

            if (comp_id == 14) {
                base_football_url = site_base_url + '/football/europe/italian-serie-a/';
            }

            if (comp_id == 75) {
                base_football_url = site_base_url + '/football/europe/german-bundesliga/';
                console.log(comp_id);
            }

            if (comp_id == 77) {
                base_football_url = site_base_url + '/football/europe/portugal/portuguese-league/';
            }

            if (comp_id == 57) {
                base_football_url = site_base_url + '/football/europe/french-ligue-1/';
            }

            link = base_football_url;


            if (status == 'live') {
                link = site_base_url;
                link_to = link + '/football-live-scores/';
                console.log(link_to);
            }

            if (status == 'fixtures') {
                link_to = link + 'fixtures/';
                console.log(link_to);
            }

            if (status == 'results') {
                link_to = link + 'results/';
                console.log(link_to);
                console.log(status);
            }

            if (comp_name == 'English Barclays Premier League') {
                comp_name = 'Premier League';
            }

            output += '<li style="z-index: 99999; cursor:pointer;"><div class="slider-standings-title">' + comp_name + '</div><div class="slider-standings-item-team1"><span class="team slider-standings-item-logo"><img src="/wp-content/themes/kwesesports/images/teamlogos/football/' + comp_id + '/' + h_team_id + '.png" /><span></span><div>' + h_team + '</div></span> <span class="score slider-standings-item-score">' + result_home + '</span></div> ' + time + ' <div class="slider-standings-item-team2"><span class="score slider-standings-item-score">' + result_away + '</span><span class="team slider-standings-item-logo"><img src="/wp-content/themes/kwesesports/images/teamlogos/football/' + comp_id + '/' + a_team_id + '.png" /><span></span><div>' + a_team + '</div></span> </div></li>';
        });

        $display.find('ul').html(output).css('display', 'block');
        $display.find('#loading_icon').css('display', 'none');

        /* Init auto moving */
        score_list_width = $score_list.width();
        moving = true;
        timer_id = setTimeout(function(){
            autoMove(move_direction);
        },5000);
    }

    /* Process xml data for Rugby */
    function processRugbyResults(xml, link){
        var $data = $(xml);
        var output = '';
        var time, comp_id, h_team, h_team_id, a_team, a_team_id, result_home, result_away, base_rugby_url;

        var site_base_url =  window.location.origin;
        console.log(site_base_url);

        $data.find('details item').each(function(idx, obj){
            time 		= moment($(obj).find('datetime').text()).format('DD MMM');
            comp_name 	= $(obj).find('comp-name').text();
            comp_id 	= $(obj).find('comp-id').text();
            h_team 		= $(obj).find('home-team').text();
            h_team_id 	= $(obj).find('home-team-id').text();
            a_team 		= $(obj).find('away-team').text();
            a_team_id 	= $(obj).find('away-team-id').text();
            result_home = $(obj).find('result-home').text();
            result_away = $(obj).find('result-away').text();
            status 	= $(obj).find('status').text();

            if (comp_id == 201) {
                base_rugby_url = site_base_url + '/rugby/tournaments/aviva-premiership/';
            }

            if (comp_id == 205) {
                base_rugby_url = site_base_url + '/rugby/tournaments/super-rugby/';
            }

            if (comp_id == 214) {
                base_rugby_url = site_base_url + '/rugby/tournaments/rugby-championship/';
            }

            if (result_home == '') {
                result_home = '&nbsp;';
            }
            if (result_away == '') {
                result_away = '&nbsp;';
            }
            if (status == 'fixtures') {
                link_to = base_rugby_url +'fixtures/'
                console.log(link_to);
            }
            if (status == 'results') {
                link_to = base_rugby_url + 'results/'
                console.log(link_to);
            }

            if (status == 'live') {
                link = site_base_url;
                link_to = link + '/rugby-live-scores/';
                console.log(link_to);
            }

            output += '<a href="'+link_to+'"><li style="z-index: 99999; cursor:pointer;"><div class="slider-standings-title">'+comp_name+'</div><div class="slider-standings-item-team1"><span class="team slider-standings-item-logo"><img src="/wp-content/themes/kwesesports/images/teamlogos/rugby/'+ comp_id+ '/'+h_team_id+'.png" /><span></span><div>' + h_team + '</div></span> <span class="score slider-standings-item-score">' + result_home + '</span></div> <p class="time">' + time + '</p> <div class="slider-standings-item-team2"><span class="score slider-standings-item-score">' + result_away + '</span><span class="team slider-standings-item-logo"><img src="/wp-content/themes/kwesesports/images/teamlogos/rugby/'+ comp_id+ '/' +a_team_id+'.png" /><span></span><div>' + a_team + '</div></span> </div></li></a>';
        });

        $display.find('ul').html(output).css('display', 'block');
        $display.find('#loading_icon').css('display', 'none');

        /* Init auto moving */
        score_list_width = $score_list.width();
        moving = true;
        timer_id = setTimeout(function(){
            autoMove(move_direction);
        },5000);
    }

    /* Process xml data for Cricket */
    function processCricketResults(xml){
        var $data = $(xml);
        var output = '';
        var time, comp_id, h_team, h_team_id, a_team, a_team_id, result_home, result_away;

        $data.find('details item').each(function(idx, obj){
            time = moment($(obj).find('datetime').text()).format('DD MMM');
            comp_id = $(obj).find('comp-id').text();
            h_team = $(obj).find('home-team').text();
            h_team_id = $(obj).find('home-team-id').text();
            a_team = $(obj).find('away-team').text();
            a_team_id = $(obj).find('away-team-id').text();
            result_home = $(obj).find('result-home').text();
            result_away = $(obj).find('result-away').text();

            if (result_home == '') {
                result_home = '&nbsp;';
            }
            if (result_away == '') {
                result_away = '&nbsp;';
            }

            output += '' +
                /* Result */  '<li><div class="slider-standings-title">Sri Lanka win by 8 wickets</div><div class="slider-standings-item-team1"><span class="team slider-standings-item-logo"><img src="/wp-content/themes/kwesesports/images/teamlogos/cricket/england.jpg" /><span></span><div>' + h_team + '</div></span> <span class="score slider-standings-item-score cricket">200/10</span><div class="slider-standings-item-score-overs-left">50</div></div> <p class="time"> </p><div class="slider-standings-item-team2"><span class="score slider-standings-item-score cricket">202/2</span><div class="slider-standings-item-score-overs-right">49.4</div><span class="team slider-standings-item-logo"><img src="/wp-content/themes/kwesesports/images/teamlogos/cricket/sri_lanka.jpg" /><span></span><div>' + a_team + '</div></span> </div></li>' +
                /* Live */    '<li><div class="slider-standings-title">Natwest Series, 1st Test - Day2, Live</div><div class="slider-standings-item-team1"><span class="team slider-standings-item-logo"><img src="/wp-content/themes/kwesesports/images/teamlogos/cricket/england.jpg" /><span></span><div>' + h_team + '</div></span> <span class="score slider-standings-item-score cricket">200/10</span></div><div class="slider-standings-item-score-overs-left">(44.5)</div></div> <p class="time"> </p><div class="slider-standings-item-team2"><span class="score slider-standings-item-score cricket">300/10</span><div class="slider-standings-item-score-overs-right">(101.2)</div><span class="team slider-standings-item-logo"><img src="/wp-content/themes/kwesesports/images/teamlogos/cricket/sri_lanka.jpg" /><span></span><div>' + a_team + '</div></span> </div></li>' +
                /* Fixture */ '<li><div class="slider-standings-title">Test Series</div><div class="slider-standings-item-team1"><span class="team slider-standings-item-logo"><img src="/wp-content/themes/kwesesports/images/teamlogos/cricket/england.jpg" /><span></span><div>' + h_team + '</div></span> <span class="score slider-standings-item-score">0/0</span></div> <p class="time">' + time + '</p> <div class="slider-standings-item-team2"><span class="score slider-standings-item-score">0/0</span><span class="team slider-standings-item-logo"><img src="/wp-content/themes/kwesesports/images/teamlogos/cricket/sri_lanka.jpg" /><span></span><div>' + a_team + '</div></span> </div></li>';
        });

        $display.find('ul').html(output).css('display', 'block');
        $display.find('#loading_icon').css('display', 'none');

        /* Init auto moving */
        score_list_width = $score_list.width();
        moving = true;
        timer_id = setTimeout(function(){
            autoMove(move_direction);
        },5000);
    }


    /* Bind events to left & right arrows */
    function bindLeftRightArrow(){
        $move_left.on('mousedown touchend', function(ev){
            ev.preventDefault();
            $display.stop(true, false);
            clearTimeout(timer_id);
            current_pos = $display.scrollLeft();
            moving = false;

            if (current_pos <= half_display_width){
                current_pos = 0;
            }
            else{
                current_pos -= half_display_width;
            }

            moveScoreDisplay(current_pos);
        });

        $move_right.on('mousedown touchend', function(ev){
            ev.preventDefault();
            $display.stop(true, false);
            clearTimeout(timer_id);
            current_pos = $display.scrollLeft();
            moving = false;

            if ((score_list_width - current_pos) <= half_display_width * 3){
                current_pos = score_list_width - half_display_width * 2;
            }
            else{
                current_pos += half_display_width;
            }

            moveScoreDisplay(current_pos);
        });
        $move_left.on('mouseleave', function(ev){
            ev.preventDefault();
            if (!moving) {
                autoMove(move_direction);
            }
        });
        $move_right.on('mouseleave', function(ev){
            ev.preventDefault();
            if (!moving) {
                autoMove(move_direction);
            }
        });
    }

    /* Bind click/touch event to categories tabs */
    function bindScoreTab(){
        $score_tabs.on('mouseup touchend', function(ev){
            ev.preventDefault();
            $score_tabs.removeClass('selected');
            $(this).addClass('selected');
            $('#score_link').attr('href', $(this).data('url'));
            loadScoreTab($(this).data('link'), $(this).data('type'), $(this).data('url'));
        });

    }

    /* Bind mouse drag / touch drag/ hover event to score display */
    function bindScoreDisplay(){
        /* Listen to mouse drag events */
        $display.on('mousedown',function(ev){
            ev.preventDefault();

            //let element = $(ev.target);

            //console.log(element);

            $(ev).on('mousemove',function(){
                dragging = false;
            });

            init = true;

            startX = ev.screenX;
            if (!dragging){
                //console.log($(element));
                //$(element).find('a').attr('href');
                //$( this ).find('ul li a').attr('href');
                // IF ELEMENT IS LI -> .FIND(A HREF)

                // ELSE .FIND(LI) -> .FIND(A HREF )
                //alert($(this).find('li > a').attr('href'));
                //window.location.href = $(this).find('li > a').attr('href');

            } else {
                //alert('');
            }

        });
        $display.on('mousemove',function(ev){
            ev.preventDefault();
            if ((init)&&(ev.screenX - startX !== 0)){
                dragging = true;
                endLeft = current_pos - (ev.screenX - startX);

                if (endLeft <= 0){
                    endLeft = 0;
                }

                if (endLeft >= (score_list_width - half_display_width * 2)){
                    endLeft = score_list_width - half_display_width * 2;
                }

                moveScoreDisplay(endLeft, true);
            }
        });
        $display.on('mouseup mouseleave',function(ev){
            ev.preventDefault();
            init = false;
            if (dragging){
                current_pos = endLeft;
                dragging = false;
            }
        });

        /* Listen to touch drag events */

        var score_display = document.getElementById('score_display');

//        if (score_display.addEventListener){
//            score_display.addEventListener('touchstart',function(ev){
//                init = true;
//                dragging = false;
//                $display.stop(true, false);
//                clearTimeout(timer_id);
//                current_pos = $display.scrollLeft();
//                moving = false;
//            });
//
//            score_display.addEventListener('touchmove',function(ev){
//                touch = ev.touches[0];
//                if (init){
//                    dragging = true;
//                    startX = touch.pageX;
//                    startY = touch.pageY;
//                    init = false;
//                }
//                endLeft = current_pos - (touch.pageX - startX);
//
//                if (Math.abs(touch.pageX - startX) > 2 * Math.abs(touch.pageY - startY)){
//                    ev.preventDefault();
//                }
//
//                if (endLeft <= 0){
//                    endLeft = 0;
//                }
//
//                if (endLeft >= (score_list_width - half_display_width * 2)){
//                    endLeft = score_list_width - half_display_width * 2;
//                }
//
//                moveScoreDisplay(endLeft, true);
//            });
//
//            score_display.addEventListener('touchend',function(ev){
//                if (dragging){
//                    current_pos = endLeft;
//                    dragging = false;
//                }
//                if (!moving) {
//                    autoMove(move_direction);
//                }
//            });
//        }

        $display.on('mouseenter', function(ev){
            ev.preventDefault();
            if (!dragging){
                $display.stop(true, false);
                clearTimeout(timer_id);
                current_pos = $display.scrollLeft();
                moving = false;
            }
        });
        $display.on('mouseleave', function(ev){
            ev.preventDefault();
            if (!moving) {
                autoMove(move_direction);
            }
        });
    }

    /* Call required functions */
    bindLeftRightArrow();
    bindScoreTab();
    bindScoreDisplay();

    // Load default tab
    $score_tabs.parent().find('li.selected').trigger('mouseup');

    // Standings Dropdown
    $('.standings-controls-dropdown-toggle').dropdown();

    // Sports Dropdown Combobox
    $(".standings-controls-dropdown-list li a").click(function(){
        var selText = $(this).text();
        $(this).parents('.standings-controls-dropdown-wrapper').find('.standings-controls-dropdown-toggle span').html(selText);
    });

    // Tournaments Dropdown Combobox
    $(".tournament-controls li a").click(function(){
        var selTournaments = $(this).text();

        $(this).parents('.tournament-controls-wrapper').find('.standings-controls-dropdown-toggle span').html(selTournaments);
    });

    // :: "Show/hide" selected sport
    function changeSport() {
        if ($('#football-active').length) {
            loadScoreTab('/score/?comp=9&section=football', 'football');
            $('.tournament-controls-football').css({ zIndex: 9998, display: 'block' });
            $('.tournament-controls-rugby').css({ zIndex: 2, display: 'none' });
            $('.tournament-controls-cricket').css({ zIndex: 2, display: 'none' });
        } else if ($('#cricket-active').length) {
            loadScoreTab('/score/?comp=3&section=cricket', 'cricket');
            $('.tournament-controls-cricket').css({ zIndex: 9998, display: 'block' });
            $('.tournament-controls-football').css({ zIndex: 2, display: 'none' });
            $('.tournament-controls-rugby').css({ zIndex: 2, display: 'none' });
        } else {
            loadScoreTab('/score/?comp=205&section=rugby', 'rugby');
            $('.tournament-controls-rugby').css({ zIndex: 9998, display: 'block' });
            $('.tournament-controls-football').css({ zIndex: 2, display: 'none' });
            $('.tournament-controls-cricket').css({ zIndex: 2, display: 'none' });
        }
    }

    // Give menu an id of the selected tournament
    $("#dropdown-football").click(function(){
        $(".standings-controls-dropdown-toggle").attr("id", "football-active");
        changeSport();
    });

    $("#dropdown-rugby").click(function(){
        $(".standings-controls-dropdown-toggle").attr("id", "rugby-active");
        changeSport();
    });

    $("#dropdown-cricket").click(function(){
        $(".standings-controls-dropdown-toggle").attr("id", "cricket-active");
        changeSport();
    });

});
(function ($, root, undefined) {
    "use strict";

    $(function () {
        var LiveMatch = {
            match_id: "",
            results: null,
            success: null,
            prefix: null,
            postfix: null,
            attr: null,

    setFixtures: function () {
        this.success = this.updateFixtures;
        this.prefix = "fixtures";
        this.postfix = "live";
        this.attr = "live";
        this.getData();
    },
    getData: function () {

        var urlPart = this.prefix + "/" + this.postfix;
        var apiUrl = $("#api_url").val();

        // the current url from here
        var options = {
            type: 'get',
            url: apiUrl + urlPart,
            dataType: "json",
            async: true,
            success: this.success,
            error: function (res, status) {
            }
        };

        options.headers = {
            "Authorization": "Basic " + btoa("developer" + ":" + "olemediagroup")
        };


        $.ajax(options);

        var $this = this;
        setTimeout(function () {
            $this.getData();
        }, 20000);
    },

    updateFixtures: function (data) {
        var html = "";
        html +=

            "<div class=\"row live-scoring-header\">" +
                "<div class=\"col-md-6 live-date\">" +
                    "<i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <span>Friday 1 July 2016</span>" +
                "</div>" +
                "<div class=\"col-md-6 filter-tournament\">" +
                    "<div class=\"datePicker__wrapper\">" +
                        "<div class=\"datePicker\">" +
                            "<select id=\"league_select\" class=\"datePicker__select tournament_picker\" name=\"tournament_select\">" +
                                "<option value=\"9999\">Filter by tournament</option>" +
                                "<option>Tournament 1</option>" +
                                 "<option>Tournament 2</option>" +
                            "</select>" +
                        "</div>" +
                    "</div>" +
                 "</div>" +
            "</div>";

        var skipCompetitions = [
            "Kenyan Premier League",
            "Scottish FA Cup",
            "Scottish Championship",
            "Scottish League One",
            "Scottish League Two",
            "Scottish Challenge Cup",
            "South African Premier Soccer League"
        ];

        var competitions = [];
        $.each(data, function (key, fixtures) {
            competitions.push({
                "name": key,
                "fixtures": fixtures
            });

        });

        $.each(_.sortBy(competitions, "name"), function (index, competition) {
            var key = competition.name;
            var fixtures = competition.fixtures;
            var templateDirectory = $("#templateDirectory").val();

            console.log(fixtures);

            html +=
            "<div class=\"fixtures-results-item\">" +
                "<div class=\"fixtures-results-heading\">" +
                    "<span class=\"fixtures-results-date\">" + key + "</span>" +
                "</div>" +
                "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" ;


            if (_.indexOf(skipCompetitions, key) === -1) {

                $.each(fixtures, function (i, fixture) {
                    var fixtureVenue = fixture.venue;
                    var homeTeam = fixture.home.team_name;
                    var awayTeam = fixture.away.team_name;
                    var home_team_id = fixture.home_team_id;
                    var away_team_id = fixture.away_team_id;
                    var fixtureId = fixture.fixture_id;
                    var homeScore = 0;
                    var awayScore = 0;
                    var fixtureTime = fixture.time;

                    if (!_.isNull(fixture.score)) {
                        homeScore = fixture.score.home_score;
                        awayScore = fixture.score.away_score;
                    }

                    var homeSlug = homeTeam.toLowerCase().replace(" ", "-");
                    var awaySlug = awayTeam.toLowerCase().replace(" ", "-");

                    var liveClass = "match-not-live";
                    var fixtureLabel = fixtureTime;

                    if (!_.isNull(fixture.result)) {
                        fixtureLabel = "FT";
                    } else if (fixture.is_live) {
                        fixtureLabel = "Live";
                    }
                    html +=
                            "<tr>" +
                                "<td class=\"group-icon-container\"><div class=\"group-icon\"><span>A</span><span>Group</span></div></td>" +
                                "<td class=\"stadium\">" + fixtureVenue + "</td>" +
                                "<td class=\"team-left-name\">" + homeTeam + "</td>" +
                                "<td class=\"team-left-logo\"><img src=" +  templateDirectory + "/images/teamlogos/" + home_team_id + ".png" + "></td>" +
                                "<td class=\"time\">" + fixtureTime + "</td>" +
                                "<td class=\"team-right-logo\"><img src=" +  templateDirectory + "/images/teamlogos/" + away_team_id + ".png" + "></td>" +
                                "<td class=\"team-right-name\">" + awayTeam + "</td>" +
                                "<td class=\"match\"><span class=\"match-page\"><a href=\"\">Match Page ></a></td>" +
                            "</tr>" ;
                });
            }
            html += "</table></div>";
        });

        $(".live-home").html(html);
        $(".fa-calendar").val( moment().format('MMM D, YYYY') );
    }
};

LiveMatch.setFixtures();

});

})(jQuery, this);
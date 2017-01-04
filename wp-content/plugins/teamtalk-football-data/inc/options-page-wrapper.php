<div class="wrap">
    <h2>TeamTalk Football Data API Settings</h2>

    <div id="post-body-content">
        <form name ="teamtalk_football_data_settings_form" method="post" action="">
            <input type="hidden" name="teamtalk_football_data_settings_form_submitted" value="Y">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Football Data API URL</th>
                    <td><input type="text" name="football_data_api_url" id="football_data_api_url" value="<?php echo $football_data_api_url; ?>" class="regular-text"/></td>
                </tr>

                <tr valign="top">
                    <th scope="row">API username</th>
                    <td><input type="text" name="football_data_api_username" id="football_data_api_username" value="<?php echo $football_data_api_username; ?>" class="regular-text"/></td>
                </tr>

                <tr valign="top">
                    <th scope="row">API password</th>
                    <td><input type="password" name="football_data_api_password" id="football_data_api_password" value="<?php echo $football_data_api_password; ?>" class="regular-text"/></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Confirm API password</th>
                    <td><input type="password" name="football_data_api_password_confirm" id="football_data_api_password_confirm" value="<?php echo $football_data_api_password_confirm; ?>" class="regular-text"/></td>
                </tr>
            </table>

            <p>
                <input class="button-primary" type="submit" name="teamtalk_football_data_settings_form_submit" value="Save API Settings" />
            </p>
        </form>
    </div>
</div>
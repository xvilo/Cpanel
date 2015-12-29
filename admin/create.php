<?php require('header.php'); ?>
    <div id="main-content">
        <div id="guts">
            <div class="container">
                <div class="row">
                    <div class="twelve columns">
                        <div class="element">
                            <h1>Create</h1>
							<select id="user_select">
								<option>Selecteer klant</option>
								<?php
									foreach (getAllUsersOption() as $user){
										echo "<option value='{$user['ID']}'>{$user['meta_value']}</option>";
									}
								?>
							</select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><?php require('footer.php'); ?>
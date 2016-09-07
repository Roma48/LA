<div id="booked-welcome-screen">
	<div class="wrap about-wrap">
		<h1><?php echo sprintf(__('Welcome to %s','booked'),'Booked '.BOOKED_VERSION); ?></h1>
		<div class="about-text">
			<?php echo sprintf(__('Thank you for choosing %s! If this is your first time using %s, you will find some helpful "Getting Started" links below. If you just updated the plugin, you can find out what\'s new in the "What\'s New" section below.','booked'),'Booked','Booked'); ?>
		</div>
		<div class="booked-badge">
			<img src="<?php echo BOOKED_PLUGIN_URL; ?>/templates/images/badge.png">
		</div>
		
		<div id="welcome-panel" class="welcome-panel">
			
			<img src="<?php echo BOOKED_PLUGIN_URL; ?>/templates/images/welcome-banner.jpg" class="booked-welcome-banner">
			
			<div class="welcome-panel-content">
				<div class="welcome-panel-column-container">
					<div class="welcome-panel-column">
					
						<iframe src="https://player.vimeo.com/video/155600760?color=56c477&title=0&byline=0&portrait=0" width="320" height="180" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="margin-top:5px;"></iframe>
						
						<h3 style="margin-top:30px;"><?php _e('Getting Started','booked'); ?></h3>
						<ul>
							<li><a href="https://boxystudio.ticksy.com/article/3239/" target="_blank" class="welcome-icon welcome-learn-more"><?php _e('Installation &amp; Setup Guide','booked'); ?></a>&nbsp;&nbsp;<i class="fa fa-external-link"></i></li>
							<li><a href="https://boxystudio.ticksy.com/article/6268/" target="_blank" class="welcome-icon welcome-learn-more"><?php _e('Custom Calendars','booked'); ?></a>&nbsp;&nbsp;<i class="fa fa-external-link"></i></li>
							<li><a href="https://boxystudio.ticksy.com/article/3238/" target="_blank" class="welcome-icon welcome-learn-more"><?php _e('Default Time Slots','booked'); ?></a>&nbsp;&nbsp;<i class="fa fa-external-link"></i></li>
							<li><a href="https://boxystudio.ticksy.com/article/3233/" target="_blank" class="welcome-icon welcome-learn-more"><?php _e('Custom Time Slots','booked'); ?></a>&nbsp;&nbsp;<i class="fa fa-external-link"></i></li>
							<li><a href="https://boxystudio.ticksy.com/article/6267/" target="_blank" class="welcome-icon welcome-learn-more"><?php _e('Custom Fields','booked'); ?></a>&nbsp;&nbsp;<i class="fa fa-external-link"></i></li>
							<li><a href="https://boxystudio.ticksy.com/article/3240/" target="_blank" class="welcome-icon welcome-learn-more"><?php _e('Shortcodes','booked'); ?></a>&nbsp;&nbsp;<i class="fa fa-external-link"></i></li>
						</ul>
						<a class="button" style="margin-bottom:15px; margin-top:0;" href="https://boxystudio.ticksy.com/articles/7827/" target="_blank"><?php _e('View all Guides','booked'); ?>&nbsp;&nbsp;<i class="fa fa-external-link"></i></a>&nbsp;
						<a class="button button-primary" style="margin-bottom:15px; margin-top:0;" href="<?php echo get_admin_url().'admin.php?page=booked-settings'; ?>"><?php _e('Get Started','booked'); ?></a>
						
					</div>
					<div class="welcome-panel-column welcome-panel-last welcome-panel-updates-list">
						<h3><?php _e('What\'s new in this update?','booked'); ?> <a href="http://boxyupdates.com/changelog.php?p=booked" target="_blank"><?php _e('Full Changelog','booked'); ?>&nbsp;&nbsp;<i class="fa fa-external-link"></i></a></h3>
						
						<ul class="booked-whatsnew-list">
							<li><em class="fix">Fixed</em> Fixed an issue with appointments not being bookable in some cases after clicking on an appointment slot.</li>
							<li><em class="fix">Fixed</em> Fixed an issue with emails not sending out when using Booked with the WooCommerce add-on.</li>
						</ul>
						<br>
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.15'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><em class="fix">Fixed</em> Includes fixes for the WooCommerce Add-On update (v1.2.22).</li>
							<li><em class="fix">Fixed</em> Added last-second checks to be sure appointment is still available before booking it (prevents double-bookings).</li>
						</ul>
						<br>
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.14'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><strong class="new">New</strong> Added a new capability called "manage_booked_options" that applies to Administrators to allow a role to access the full Booked Settings panel like an administrator does. You can use a plugin like <a href="https://wordpress.org/plugins/user-roles-and-capabilities/" target="_blank">User Roles and Capabilities</a> to accomplish this.</li>
						</ul>
						<br>
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.13'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><em class="fix">Fixed</em> Small updates and fixes throughout.</li>
						</ul>
						<br>
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.12'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><em class="fix">Fixed</em> Fixes with appointments not showing up properly in some cases.</li>
						</ul>
						<br>
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.11'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><em class="fix">Fixed</em> Several fixes with certain tokens not working in notification emails.</li>
							<li><em class="fix">Fixed</em> Several improvements and fixes to the booking form modal on mobile devices.</li>
							<li><em class="fix">Fixed</em> Fixed an issue with AJAX not working with subfolder WordPress installs.</li>
						</ul>
						<br>
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.10'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><strong class="new">New</strong> More buffer options.</li>
							<li><em class="fix">Fixed</em> Fixed a few issues with admin booking.</li>
						</ul>
						<br>
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.9'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><strong class="new">New</strong> Added the ability to "Delete Passed", "Delete All", and "Approve All" to the Pending Appointments list.</li>
							<li><em class="fix">Fixed</em> Fixed an issue where the booking form would keep loading on submit.</li>
							<li><em class="fix">Fixed</em> Fixed an issue when using the Booked WooCommerce Add-On.</li>
							<li><em class="fix">Fixed</em> Minor stylistic fixes.</li>
						</ul>
						<br>
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.8'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><strong class="new">New</strong> Proper AJAX loading (should fix a lot of issues where this was a problem).</li>
							<li><strong class="new">New</strong> Email not required anymore for Guest Bookings (unless you make it required from the Settings panel).</li>
							<li><strong class="new">New</strong> New users can now set their own password, and can log in using email address.</li>
							<li><em class="fix">Fixed</em> Guest Bookings show up properly in public front-end appointment list (if enabled).</li>
							<li><em class="fix">Fixed</em> Guest booking names/emails are properly included with Export now.</li>
							<li><em class="fix">Fixed</em> Fixes with appointment list display.</li>
							<li><em class="fix">Fixed</em> "Add to Calendar" button will now show up with [booked-appointments] shortcode.</li>
							<li><em class="fix">Fixed</em> Calendar Name now shows up with the CSV Export.</li>
						</ul>
						<br>
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.7'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><strong class="new">New</strong> Replaced "Add to Google" with "Add to Calendar", which now includes many more options (iCal, Google, Yahoo, Outlook, etc.)</li>
							<li><em class="fix">Fixed</em> Fixed a few stylistic issues with the calendar borders and modal window scrollbars.</li>
							<li><em class="fix">Fixed</em> Fixed the "end time" showing up in emails when hiding end times is active.</li>
							<li><em class="fix">Fixed</em> Fixed a fairly major bug with the "Prevent Before/After" settings.</li>
						</ul>
						<br>
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.6'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><em class="fix">Fixed</em> Fixed a date formatting issue with the datepicker on the settings panel.</li>
							<li><em class="fix">Fixed</em> Some other very minor bug fixes.</li>
						</ul>
						<br>
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.5'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><strong class="new">New</strong> Added a date picker to the appointment list view to jump to a specific day.</li>
							<li><strong class="new">New</strong> Added an Admin Bar dropdown menu for quick access anywhere (with option to hide it).</li>
							<li><em class="fix">Fixed</em> Lots of bug fixes with the calendar/list displays (showing the correct start date, etc.).</li>
							<li><em class="fix">Fixed</em> Fixed an ordering issue with the Upcoming Appointments Dashboard widget.</li>
							<li><em class="fix">Fixed</em> Taller modal window, especially on smaller screens.</li>
							<li><em class="fix">Fixed</em> Fixed more than several bugs with custom time slots.</li>
							<li><em class="fix">Fixed</em> Some minor language file updates.</li>
						</ul>
						<br>
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.4'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><em class="fix">Fixed</em> Fixed the "No Redirect" option for appointments in "List View".</li>
							<li><em class="fix">Fixed</em> More language fixes/updates.</li>
							<li><em class="fix">Fixed</em> More front-end stylistic adjustments.</li>
						</ul>
						<br>						
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.3'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><strong class="new">New</strong> Changed "Time Slots Available" to "Spaces Available" in most places.</li>
							<li><strong class="new">New</strong> Booked now hides the "# Spaces Available" text in the appointment list if you cannot book it anymore.</li>
							<li><em class="fix">Fixed</em> Language file fixes/update.</li>
							<li><em class="fix">Fixed</em> Admin stylistic adjustments.</li>
							<li><em class="fix">Fixed</em> Front-end stylistic adjustments.</li>
						</ul>
						<br>
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.2'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><em class="fix">Fixed</em> Language file update.</li>
							<li><em class="fix">Fixed</em> Bug fixes update.</li>
						</ul>
						<br>
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.1'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><strong class="new">New</strong> A "Public Appointments" option has been added. Now you can display (on the front-end) who has booked each time slot. Great for meeting rooms, etc.</li>
							<li><strong class="new">New</strong> Added a link to the top of the Settings panel to get back to this "Welcome to Booked" screen.</li>
							<li><em class="fix">Fixed</em> The issue with booking on the correct appointment "list view" calendar has been fixed.</li>
							<li><em class="fix">Fixed</em> The calendar switcher on the appointment "list view" has been fixed. Sorry about that!</li>
							<li><em class="fix">Fixed</em> Admin calendar arrows stylistic fix (for sites with no custom calendars).</li>
							<li><em class="fix">Fixed</em> A few smaller bugs from 1.7.0 have been squashed!</li>
						</ul>
						<br>
						
						<h3><?php echo sprintf(__('%s Update','booked'),'1.7.0'); ?></h3>
						<ul class="booked-whatsnew-list">
							<li><strong class="new">New</strong> Complete styling update. Appointment calendars, modal windows, animations and more have all been majorly polished.</li>
							<li><strong class="new">New</strong> The front-end Profile has been redesigned. The nearly pointless "Website" and "Short Bio" fields have been removed to clean it up.</li>
							<li><strong class="new">New</strong> The new [booked-profile] shortcode is now used to display the Profile (instead of choosing a page in the Settings panel).</li>
							<li><strong class="new">New</strong> The [booked-calendar] shortcode has a new "style" setting to display a single day "list" instead of the full calendar. (i.e. [booked-calendar <strong>style="list"</strong>])</li>
							<li><strong class="new">New</strong> The [booked-calendar] shortcode has a new "day" setting to display a specific day (for use in conjunction with the "list" style above). (i.e. [booked-calendar month="4" <strong>day="2"</strong>])</li>
							<li><strong class="new">New</strong> Added the ability to export appointments to a CSV file with multiple options for output. (All Appointments, Pending, Approved, Upcoming, Past, etc.)</li>
							<li><strong class="new">New</strong> A new <em>"Text Content"</em> custom field is now available (to add text/html content to your booking form).</li>
							<li><strong class="new">New</strong> You can now choose a specific month and/or year for the calendar widget.</li>
							<li><strong class="new">New</strong> New option to not redirect anywhere upon booking (makes it easier to book multiple appointments).</li>
							<li><strong class="new">New</strong> "Guest Mode" now works with the WooCommerce add-on.</li>
							<li><strong class="new">New</strong> Email content textareas on the Settings page are now visual editors.</li>
							<li><strong class="new">New</strong> Added options to globally prevent appointments from getting booked before and after specific dates.</li>
							<li><strong class="new">New</strong> Added more hide/show options for the calendar elements.</li>
							<li><em class="fix">Fixed</em> Better WPML support.</li>
							<li><em class="fix">Fixed</em> If no appointments are available in the current month, the next available month will be displayed (only if you have not specified a month and/or year in the calendar shortcode).</li>
							<li><em class="fix">Fixed</em> Fixed a bug where a start of week setting of "Monday" would still start with "Sunday".</li>
							<li><em class="fix">Fixed</em> Cancellation emails are no longer sent out if the appointment has passed.</li>
							<li><em class="fix">Fixed</em> Fixed a bug where the page would reload inside the calendar before redirecting (for new registrations).</li>
							<li><em class="fix">Fixed</em> Bug fixes throughout.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
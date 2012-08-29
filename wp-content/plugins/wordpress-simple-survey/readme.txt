=== Wordpress Simple Survey ===
Contributors: richard_steeleagency
Donate link: http://labs.saidigital.co/products/wordpress-simple-survey/
Tags: survey, quiz, poll, exam, test, questionnaire
Requires at least: 3.3.1
Tested up to: 3.3.1
Stable tag: 2.2.6

A WordPress Survey and Quiz plugin that displays basic weighted survey, then routes user to location based on score, and allows tracking and emails.

== Description ==

Wordpress Simple Survey is a plugin that allows for the creation of a survey, poll, quiz, or questionnaire and the tracking of user submissions. Scores, Names, and Results can be recorded, emailed, and displayed in the WordPress backend. The plugin is jQuery based which allows users to seamlessly and in a graphically appealing manner, take the quiz without reloading the page. Each answer is given a weight (or score/points). Once a quiz is submitted, the user is taken to a predefined URL based on their score range; this page can be any URL including pages setup in WordPress that can contain information relevant to the particular scoring range, including the user's score and answer set. The plugin can also keep a record of all submissions and email results to a predefined email address. 

* [Project Homepage](http://labs.saidigital.co/products/wordpress-simple-survey/)
* [Support](http://labs.saidigital.co/products/wordpress-simple-survey/support-2/)
* [Extended Version](http://labs.saidigital.co/products/wordpress-simple-survey/wordpress-simple-survey-extended-version/)

== Installation ==

1. Upload plugin to the 'wp-content/plugins/' directory. Ensure that there is only one WPSS folder and it is named "wordpress-simple-survey".
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Once activated the new menu item: WPSS Options, is created
4. Configure your options, make sure to select the number of questions you want and click 'Update'
5. Enter Questions, Answers, Weights, and Routes in the format specified, DO NOT PASTE FROM MS WORD, use a basic text editor

== Frequently Asked Questions ==

= Are the results tracked? =

The results, Name, and Email addresses are stored in your database, and display in the 'WPSS Results' menu.

= I don't want the user to be immediately directed to the end page, how can I create a buffer page? =

Simple, instead of linking a score range with the end page, link each range with a separate buffer page that explains their score(or whatever) and then have that page link to the end page.

= What type of quizzes can I create? =

Two obvious ways of using this plugin are to create a Survey-Type quiz that routes user to a location based on their input, another is to use the plugin as a Quiz-Type manager where users are routed to either a "Passing" or "Failing" page. Also note, that results are recorded along with the user's email address (if this option is selected), so for a Survey-Type quiz, an admin can follow up with the user (market to them based on responses to quiz), or an admin can administer a test and record who passed and who failed. 

= How do I make the quiz show up in my content? =

Add the string: [wp-simple-survey-1] to an article.

== Screenshots ==

1. Using quiz
2. Progress Bar
3. Submit Results
4. Email Results
5. Backend Quiz Management
6. Backend Results View
7. Diagram

== Changelog ==

= 2.2.9 =
* Worked on fixing SSL bug for queued assets. 

= 2.2.8 =
* Linked to quizzes by name instead of ID on Admin.

= 2.2.7 =
* Buffered variables to remove remaining WP_DEBUG warnings on some setups.

= 2.2.6 =
* Added full paths to include statements to avoid issues with PHP path issues on specific hosts.

= 2.2.5 =
* Forced UTF support through dbDelta function.

= 2.2.4 =
* Added new WordPress TinyMCE API to email textarea and question textarea (Extended Version now has media manager with textareas).

= 2.2.3 =
* Added htmlspecialchars to results preview. Linked to new support forums and plugin site.

= 2.2.2 =
* Added empty buffers to inputs of some extra functions.

= 2.2.1 = 
* Changed folder structure. Fixed quiz results display to remove HTML tags.

= 2.2.0 = 
* Added separate JS plugin file for ui.widget and ui.progressbar for better JS compatability. Cleaned up CSS and markup.

= 2.1.0 =
* Added admin control for add_filter priority

= 2.0.3 =
* Inserted code to prevent errors on foreach for uninitialized variables

= 2.0.2 =
* Reluctantly added ability to turn of properly imported jQuery do to harded imports in poorly written themes and plugins. API? What's that?

= 2.0.0 =
* Rewrote plugin allowing for multiple quizzes, better storage of answers, custom fields, and much more

= 1.5.3 =
* Fixed Next button bug on submit slide click trigger

= 1.5.2 =
* Changed function name for more compatability

= 1.5.1 =
* Gave Admin function calls less generic names for more compatability
* Changed jQuery Tools import function on backend, to execute only when needed, for more capatibility

= 1.5.0 =
* Added Auto-Respond Functionality 
* Changed php::mail() function to wp_mail() function from WP API
* Modified Admin look and feel

= 1.4.1 =
* Improved CSS to reset spacing and padding on more themes

= 1.4 =
* Improved mail() function and admin CSS

= 1.3 =
* Fixed bug in function that registers WPSS Menus in backend.

= 1.2 =
* Improved import method for all javascript libraries. WPSS is now using WP native versions of jQuery & jQuery-UI core. These import in noConflict() mode which is taken advantage of by the plugin. This ensures fewer conflict with existing plugins and themes. Checkform JS method is also updated (by name only); it is now wpss_checkForm(form), this also reduces conflict with existing themes' and plugins' checkform methods. 

= 1.1 =
* Changed jQueryUI import method to ensure that only one copy is being registered

= 1.0 =
* Originating version.

== Upgrade Notice ==

= 2.2.5  =
Table collations and charsets are now UTF. However, existing databases cannot easily be changed through the plugin. If you need UTF characters, you will have to delete your WPSS database tables and then deactivate and then activate the plugin to generate new tables with UTF collation.

= 2.2.1  =
Because the folder structure has changed, you may need to delete the 'wordpress-simple-survey' folder and replace with this update. You will not lose any data.

= 2.0.0 =
When upgrading to 2.0.0 from 1.5, quizzes will have to be re-inserted

= 1.4 =
Improved mail() function and admin CSS

= 1.3 =
Fixed bug in function that registers WPSS Menus in backend.

= 1.2 =
Improved import method for all javascript libraries. WPSS is now using WP native versions of jQuery & jQuery-UI core. These import in noConflict() mode which is taken advantage of by the plugin. This ensures fewer conflict with existing plugins and themes. Checkform JS method is also updated (by name only); it is now wpss_checkForm(form), this also reduces conflict with existing themes' and plugins' checkform methods. 

= 1.1 =
Changed jQueryUI import method to ensure that only one copy is being registered

= 1.0 =
None

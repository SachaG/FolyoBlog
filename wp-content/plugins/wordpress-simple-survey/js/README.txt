See:

http://codex.wordpress.org/Function_Reference/wp_enqueue_script

before doing anything stupid.




Secondly,

WordPress 3.1's jQuery-UI doesn't include ui.widget and ui.progressbar apparently (or at least they're not compatable) therefore using WP's shipped version of UI isn't gonna work for the plugin, and using a new script file with just ui.widget and ui.progressbar will likely break other people's plugins using ui.widget


Current solution:

Download the full jQuery-UI directly from jQuery and ship it with plugin. De-Register any registered WordPress jQuery-UI and register the big boy.



Here's all the WP UI's available
jquery-ui-core, jquery-ui-tabs, jquery-ui-sortable, jquery-ui-draggable, jquery-ui-droppable, jquery-ui-selectable, jquery-ui-resizable, jquery-ui-dialog 
De-Register all, and register full version that contains all.

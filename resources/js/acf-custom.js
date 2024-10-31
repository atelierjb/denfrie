document.addEventListener('DOMContentLoaded', function () {
    if (typeof acf !== 'undefined') {
        acf.addFilter('wysiwyg_tinymce_settings', function(mceInit, id) {
            // Customize the TinyMCE toolbar to include 'sectionbreak'
            mceInit.toolbar1 = 'italic,link,formatselect,sectionbreak'; // Added 'sectionbreak' to the toolbar
            mceInit.toolbar2 = ''; // Ensure this is empty to remove additional options
            mceInit.menubar = false; // Hide the menu bar
            mceInit.plugins = mceInit.plugins ? mceInit.plugins + ' sectionbreak' : 'sectionbreak'; // Add 'sectionbreak' plugin

            // Customize block formats to only allow h4
            mceInit.block_formats = 'Heading 4=h4;Paragraph=p';

            // Remove additional buttons
            mceInit.toolbar1 = mceInit.toolbar1.replace(/underline|blockquote|bullist/g, '');

            return mceInit;
        });

        // Define and register the 'sectionbreak' TinyMCE plugin
        if (typeof tinymce !== 'undefined') {
            tinymce.PluginManager.add('sectionbreak', function(editor) {
                editor.addButton('sectionbreak', {
                    title: 'Insert Section Break',
                    text: 'Tilføj nyt tekstafsnit', // Add text label instead of icon
                    onclick: function() {
                        editor.insertContent('<div class="section-break"></div>'); // Invisible marker
                    }
                });
            });
        }
    }
});

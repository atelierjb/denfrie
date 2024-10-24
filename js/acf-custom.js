document.addEventListener('DOMContentLoaded', function () {
    if (typeof acf !== 'undefined') {
        acf.addFilter('wysiwyg_tinymce_settings', function(mceInit, id) {
            // Customize the TinyMCE toolbar
            mceInit.toolbar1 = 'italic,link,formatselect';
            mceInit.toolbar2 = ''; // Ensure this is empty to remove additional options
            mceInit.menubar = false; // Hide the menu bar
            mceInit.plugins = 'link'; // Restrict to only the link plugin

            // Customize block formats to only allow h4
            mceInit.block_formats = 'Heading 4=h4;Paragraph=p';

            // Remove additional buttons
            mceInit.toolbar1 = mceInit.toolbar1.replace(/underline|blockquote|bullist/g, '');

            return mceInit;
        });
    }
});

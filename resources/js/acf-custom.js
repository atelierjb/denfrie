document.addEventListener('DOMContentLoaded', function () {
    if (typeof acf !== 'undefined') {
        acf.addFilter('wysiwyg_tinymce_settings', function(mceInit, id) {
            // Add indent-paragraph to valid elements
            mceInit.valid_elements = mceInit.valid_elements ? mceInit.valid_elements + ',p[class],h4' : 'p[class],h4';
            mceInit.extended_valid_elements = mceInit.extended_valid_elements ? mceInit.extended_valid_elements + ',p[class],h4' : 'p[class],h4';
            
            // Preserve empty paragraphs
            mceInit.remove_linebreaks = false;
            mceInit.keep_styles = true;
            mceInit.verify_html = false;
            mceInit.forced_root_block = 'p';
            mceInit.force_br_newlines = false;
            mceInit.force_p_newlines = true;
            
            // Customize the TinyMCE toolbar
            mceInit.toolbar1 = 'formatselect,removeformat,italic,link,paragraphindent';
            mceInit.toolbar2 = '';
            mceInit.menubar = false;
            mceInit.plugins = mceInit.plugins ? mceInit.plugins + ' paragraphindent paste' : 'paragraphindent paste';

            // Customize block formats
            mceInit.block_formats = 'Heading 4=h4;Paragraph=p';

            // Remove additional buttons
            mceInit.toolbar1 = mceInit.toolbar1.replace(/underline|blockquote|bullist/g, '');

            return mceInit;
        });

        // Define and register the 'paragraphindent' TinyMCE plugin
        if (typeof tinymce !== 'undefined') {
            tinymce.PluginManager.add('paragraphindent', function(editor) {
                editor.addButton('paragraphindent', {
                    title: 'Add Paragraph Indent',
                    icon: 'indent',
                    onclick: function() {
                        const node = editor.selection.getNode();
                        if (node.nodeName === 'P') {
                            // Toggle class and force editor update
                            if (node.classList.contains('indent-paragraph')) {
                                editor.dom.removeClass(node, 'indent-paragraph');
                            } else {
                                editor.dom.addClass(node, 'indent-paragraph');
                            }
                            // Force a visual update
                            editor.fire('NodeChange');
                        }
                    },
                    // Add active state handling
                    onPostRender: function() {
                        const btn = this;
                        editor.on('NodeChange', function(e) {
                            btn.active(e.element.classList.contains('indent-paragraph'));
                        });
                    }
                });
            });
        }
    }
});

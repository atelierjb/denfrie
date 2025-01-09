document.addEventListener('DOMContentLoaded', function () {
    if (typeof acf !== 'undefined') {
        acf.addFilter('wysiwyg_tinymce_settings', function(mceInit, id) {
            // Add indent-paragraph to valid elements
            const validElements = 'p[class],h4[class]';
            mceInit.valid_elements = mceInit.valid_elements ? mceInit.valid_elements + ',' + validElements : validElements;
            mceInit.extended_valid_elements = mceInit.extended_valid_elements ? mceInit.extended_valid_elements + ',' + validElements : validElements;
            
            // Preserve empty paragraphs
            mceInit.remove_linebreaks = false;
            mceInit.keep_styles = true;
            mceInit.verify_html = false;
            mceInit.verify_html_strict = false;
            mceInit.forced_root_block = 'p';
            mceInit.force_br_newlines = false;
            mceInit.force_p_newlines = true;
            mceInit.remove_redundant_brs = false;
            
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
                    title: 'Add/Remove Paragraph Indent',
                    icon: 'indent',
                    onclick: function() {
                        // Get the selected content
                        const selectedContent = editor.selection.getContent();
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = selectedContent;
                        
                        // Find all paragraphs in the selection
                        const paragraphs = editor.selection.getSelectedBlocks();
                        
                        if (paragraphs.length > 0) {
                            // Check if the first non-empty paragraph has no-indent to determine action
                            const firstNonEmptyParagraph = Array.from(paragraphs).find(p => 
                                p.nodeName === 'P' && p.textContent.trim() !== ''
                            );
                            
                            const shouldAdd = firstNonEmptyParagraph ? 
                                !firstNonEmptyParagraph.classList.contains('no-indent') : 
                                !paragraphs[0].classList.contains('no-indent');
                            
                            // Apply the same action to all non-empty selected paragraphs
                            paragraphs.forEach(function(p) {
                                if (p.nodeName === 'P' && p.textContent.trim() !== '') {
                                    if (shouldAdd) {
                                        editor.dom.addClass(p, 'no-indent');
                                    } else {
                                        editor.dom.removeClass(p, 'no-indent');
                                    }
                                }
                            });
                            
                            // Force a visual update
                            editor.fire('NodeChange');
                        }
                    },
                    // Add active state handling
                    onPostRender: function() {
                        const btn = this;
                        editor.on('NodeChange', function(e) {
                            // Check if any selected non-empty paragraph has no-indent
                            const selectedBlocks = editor.selection.getSelectedBlocks();
                            const hasNoIndent = selectedBlocks.some(block => 
                                block.nodeName === 'P' && 
                                block.textContent.trim() !== '' && 
                                block.classList.contains('no-indent')
                            );
                            btn.active(hasNoIndent);
                        });
                    }
                });
                editor.on('keydown', function(e) {
                    if (e.keyCode === 13) { // Enter key
                        setTimeout(function() { // Use setTimeout to ensure the new line is created
                            const selectedBlocks = editor.selection.getSelectedBlocks();
                            selectedBlocks.forEach(function(block) {
                                if (block.nodeName === 'P' && block.classList.contains('no-indent')) {
                                    editor.dom.removeClass(block, 'no-indent');
                                }
                            });
                        }, 0);
                    }
                });
            });
        }
    }
});

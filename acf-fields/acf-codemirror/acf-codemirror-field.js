(function($) {
    'use strict';

    /**
     * Initialize CodeMirror editors
     */
    function initializeCodeMirror($field) {
        var $textarea = $field.find('textarea.acf-codemirror-field');

        if ($textarea.length === 0) {
            return;
        }

        // Check if CodeMirror is already initialized
        if ($textarea.data('codemirror-initialized')) {
            return;
        }

        var fieldId = $textarea.attr('id');
        var mode = $textarea.data('mode') || 'css';
        var theme = $textarea.data('theme') || 'default';
        var lineNumbers = $textarea.data('line-numbers') !== false;
        var lineWrapping = $textarea.data('line-wrapping') !== false;
        var height = $textarea.data('height') || '300px';

        // Create CodeMirror instance
        var editor = CodeMirror(document.getElementById(fieldId + '-editor'), {
            value: $textarea.val(),
            mode: mode,
            theme: theme,
            lineNumbers: lineNumbers,
            lineWrapping: lineWrapping,
            indentUnit: 4,
            tabSize: 4,
            indentWithTabs: true,
            matchBrackets: true,
            autoCloseBrackets: true,
            autoCloseTags: (mode === 'htmlmixed' || mode === 'xml'),
            styleActiveLine: true,
            hintOptions: {
                completeSingle: false,
                closeOnUnfocus: false
            },
            extraKeys: {
                "Ctrl-Space": "autocomplete",
                "Ctrl-/": "toggleComment",
                "Cmd-/": "toggleComment",
                "Tab": function(cm) {
                    if (cm.somethingSelected()) {
                        cm.indentSelection("add");
                    } else {
                        cm.replaceSelection(cm.getOption("indentWithTabs")? "\t":
                            Array(cm.getOption("indentUnit") + 1).join(" "), "end", "+input");
                    }
                }
            }
        });

        // Auto-hint on typing for CSS mode
        if (mode === 'css') {
            editor.on("inputRead", function(cm, change) {
                if (change.text[0] && /[a-zA-Z-]/.test(change.text[0])) {
                    CodeMirror.commands.autocomplete(cm, null, {completeSingle: false});
                }
            });
        }

        // Set height
        editor.setSize(null, height);

        // Sync changes back to textarea
        editor.on('change', function() {
            $textarea.val(editor.getValue());
            $textarea.trigger('change');
        });

        // Store editor instance
        $textarea.data('codemirror-instance', editor);
        $textarea.data('codemirror-initialized', true);

        // Refresh editor after a short delay (fixes rendering issues)
        setTimeout(function() {
            editor.refresh();
        }, 100);
    }

    /**
     * ACF ready event
     */
    if (typeof acf !== 'undefined') {
        acf.addAction('ready', function($el) {
            $('.acf-field-codemirror').each(function() {
                initializeCodeMirror($(this));
            });
        });

        acf.addAction('append', function($el) {
            $el.find('.acf-field-codemirror').each(function() {
                initializeCodeMirror($(this));
            });
        });

        acf.addAction('show', function($field) {
            if ($field.hasClass('acf-field-codemirror')) {
                var editor = $field.find('textarea.acf-codemirror-field').data('codemirror-instance');
                if (editor) {
                    setTimeout(function() {
                        editor.refresh();
                    }, 10);
                }
            }
        });
    }

    /**
     * Legacy support for older ACF versions
     */
    $(document).ready(function() {
        // Initialize on page load
        $('.acf-field-codemirror').each(function() {
            initializeCodeMirror($(this));
        });

        // Initialize when repeater/flexible content adds new row
        $(document).on('click', '.acf-repeater .acf-button, .acf-flexible-content .acf-button', function() {
            setTimeout(function() {
                $('.acf-field-codemirror').each(function() {
                    if (!$(this).find('textarea.acf-codemirror-field').data('codemirror-initialized')) {
                        initializeCodeMirror($(this));
                    }
                });
            }, 500);
        });

        // Refresh editors when tabs are switched
        $(document).on('click', '.acf-tab-button', function() {
            setTimeout(function() {
                $('.acf-field-codemirror').each(function() {
                    var editor = $(this).find('textarea.acf-codemirror-field').data('codemirror-instance');
                    if (editor) {
                        editor.refresh();
                    }
                });
            }, 100);
        });

        // Refresh editors when accordion is opened
        $(document).on('click', '.acf-accordion-title', function() {
            setTimeout(function() {
                $('.acf-field-codemirror').each(function() {
                    var editor = $(this).find('textarea.acf-codemirror-field').data('codemirror-instance');
                    if (editor) {
                        editor.refresh();
                    }
                });
            }, 100);
        });
    });

})(jQuery);

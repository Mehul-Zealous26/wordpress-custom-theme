
/* eslint-disable */

(function($) {

    'use strict';

    const CpBlocksForACF = {

        // properties
        flexFields: {},
        currentFlexible: null,
        $actionMenu: null,
		isVer65: false,


        // initialize
        init: function() {
            if (!window.acf) {
                return;
            }
			CpBlocksForACF.isVer65 = document.querySelectorAll(".tmpl-more-layout-actions").length > 0;
            CpBlocksForACF.appendButtons();

			// place listener on "copy layout" option
			if (CpBlocksForACF.isVer65) { // for ACF 6.5+ we must capture event
				document.addEventListener('click', function(e) {
					if (e.target.matches('.acf-copy-layout')) {
						CpBlocksForACF.onLayoutCopy(e);
					}
				}, true);
			} else { // for older versions of ACF plugin
				$(document).on('click', '.acf-fc-layout-controls .-copy', CpBlocksForACF.onLayoutCopy);
			}

			// hide menu
            $(document).on('click', CpBlocksForACF.closeActionMenu);
        },


        // render buttons
        appendButtons() {
            window.acf.addAction('ready_field/type=flexible_content', function(field) {
                CpBlocksForACF.flexFields[field.data.key] = field;

				// for older version add "copy" button on block header
				if (!CpBlocksForACF.isVer65) {
					field.$el.find('.layout').each(function (i, e) {
						const button = '<a data-name="copy-layout" class="acf-icon acf-copy-icon -copy small light acf-js-tooltip" href="#" title="Copy layout"></a>';
						$(button).insertAfter($(e).find('.acf-fc-layout-controls .-plus'));
					});
				}

                // place button for action menu in footer
                const actionButton = '<a class="button cpblocksforacf-action-menu-button" href="javascript:;">\n' +
                    '<span class="dashicons dashicons-ellipsis cpblocksforacf-action-menu-div"></span>\n' +
                    '</a>';
                const $actionButton = $(actionButton);
                field.$el.find('.acf-actions:last [data-name="add-layout"]').parent().prepend($actionButton);
                $actionButton.on('click', (event) => CpBlocksForACF.showActionMenu(event, $actionButton));
            });
        },


        // render menu
        showActionMenu(event, $button) {
            event.stopPropagation();
            const actionMenu = '<div class="js-cpblocksforacf-action-menu acf-tooltip acf-fc-popup cpblocksforacf-popup">'
                +'<a href="javascript:;" data-action="paste">Paste layouts</a>'
                +'<a href="javascript:;" data-action="copy-all">Copy all layouts</a>'
                +'</div>';
            if (CpBlocksForACF.$actionMenu) {
                CpBlocksForACF.$actionMenu.remove();
            }
            CpBlocksForACF.$actionMenu = $(actionMenu);
            $button.parent().append(CpBlocksForACF.$actionMenu);
            CpBlocksForACF.$actionMenu.on('click', (event) => {
                const $target = $(event.target);
                if ($target.data('action') === 'paste') CpBlocksForACF.onPaste($target);
                if ($target.data('action') === 'copy-all') CpBlocksForACF.onCopyAll($target);
            });
        },


        // hide action menu
        closeActionMenu() {
            if (CpBlocksForACF.$actionMenu) {
                CpBlocksForACF.$actionMenu.remove();
            }
        },


        // handle click on "copy layout"
        onLayoutCopy(e, $el) {
            const $target = CpBlocksForACF.isVer65
				? $('.acf-more-layout-actions').data().acf.data.target  // for ACF 6.5+ we must find $target in data
				: $(e.target);

            // vars
            const $layout = $target.closest('.layout').clone();
            const source = $target.closest('.acf-flexible-content').find('> input[type=hidden]').attr('name');

            // fix content
            CpBlocksForACF.fixInputs($layout);
            CpBlocksForACF.cleanLayouts($layout);

            // get layout data
            const data = JSON.stringify({
                domain: window.location.origin,
                source: source,
                layouts: $layout[0].outerHTML
            });

            // show message
            CpBlocksForACF.copyToClipboard(data, {
                auto: "Layout data has been copied to your clipboard.\nYou can now paste it on another page, using the [Paste] button action.",
                manual: "Please copy the following data to your clipboard.\nYou can then paste it on another page, using the [Paste] button action.",
            });
        },


        // normalize values of input fields
        fixInputs($layout) {
            $layout.find('input').each(function() {
                $(this).attr('value', this.value);
            });
            $layout.find('textarea').each(function() {
                $(this).html(this.value);
            });
            $layout.find('input:radio,input:checkbox').each(function() {
                $(this).attr('checked', this.checked ? 'checked' : false);
            });
            $layout.find('option').each(function() {
                $(this).attr('selected', this.selected ? 'selected' : false);
            });
        },


        // normalize html of blocks
        cleanLayouts($layout) {
            // Clean WP Editor
            $layout.find('.acf-editor-wrap').each(function() {
                $(this).find('.wp-editor-container div').remove();
                $(this).find('.wp-editor-container textarea').css('display', '');
            });
            // Clean Block Editor
            //$layout.find('.acfe-block-editor-wrapper').each(function() {
            //    $(this).find('.editor').remove();
            //});
			// Clean popup
			$layout.find('.acf-more-layout-actions').each(function() {
				$(this).remove();
			});
            // Clean Date
            $layout.find('.acf-date-picker').each(function() {
                $(this).find('input.input').removeClass('hasDatepicker').removeAttr('id');
            });
            // Clean Time
            $layout.find('.acf-time-picker').each(function() {
                $(this).find('input.input').removeClass('hasDatepicker').removeAttr('id');
            });
            // Clean DateTime
            $layout.find('.acf-date-time-picker').each(function() {
                $(this).find('input.input').removeClass('hasDatepicker').removeAttr('id');
            });
            // Clean Code Editor
            //$layout.find('.acfe-field-code-editor').each(function() {
            //    $(this).find('.CodeMirror').remove();
            //});
            // Clean Color Picker
            $layout.find('.acf-color-picker').each(function() {
                var $input = $(this);
                var $color_picker = $input.find('> input');
                var $color_picker_proxy = $input.find('.wp-picker-container input.wp-color-picker').clone();
                $color_picker.after($color_picker_proxy);
                $input.find('.wp-picker-container').remove();
            });
            // Clean Post Object
            $layout.find('.acf-field-post-object').each(function() {
                $(this).find('> .acf-input span').remove();
                $(this).find('> .acf-input select').removeAttr('tabindex aria-hidden').removeClass();
            });
            // Clean Page Link
            $layout.find('.acf-field-page-link').each(function() {
                $(this).find('> .acf-input span').remove();
                $(this).find('> .acf-input select').removeAttr('tabindex aria-hidden').removeClass();
            });
            // Clean Select2
            $layout.find('.acf-field-select, .acf-field-taxonomy, .acf-field-user').each(function() {
                $(this).find('> .acf-input span.select2').remove();
                $(this).find('> .acf-input select').removeAttr('tabindex aria-hidden').removeClass();
            });
            // Clean FontAwesome
            $layout.find('.acf-field-font-awesome').each(function() {
                $(this).find('> .acf-input span').remove();
                $(this).find('> .acf-input select').removeAttr('tabindex aria-hidden');
            });
            // Clean Tab
            $layout.find('.acf-tab-wrap').each(function() {
                var $wrap = $(this);
                var $content = $wrap.closest('.acf-fields');
                var tabs = [];
                $.each($wrap.find('li a'), function() {
                    tabs.push($(this));
                });
                $content.find('> .acf-field-tab').each(function() {
                    const $current_tab = $(this);
                    $.each(tabs, function() {
                        var $this = $(this);
                        if ($this.attr('data-key') !== $current_tab.attr('data-key')) return;
                        $current_tab.find('> .acf-input').append($this);
                    });
                });
                $wrap.remove();
            });
            // Clean Accordion
            $layout.find('.acf-field-accordion').each(function() {
                $(this).find('> .acf-accordion-title > .acf-accordion-icon').remove();
                // Append virtual endpoint after each accordion
                $(this).after('<div class="acf-field acf-field-accordion" data-type="accordion"><div class="acf-input"><div class="acf-fields" data-endpoint="1"></div></div></div>');
            });
        },


        // push content to the clipboard
        copyToClipboard(data, message) {
            // default message
            message = window.acf.parseArgs(message, {
                auto: window.acf.__('Data has been copied to your clipboard.'),
                manual: window.acf.__('Please copy the following data to your clipboard.'),
            });
            // fallback for browsers that don't support navigator.clipboard
            const fallbackCopy = function(data, message) {
                const $input = $('<input type="text" style="clip:rect(0,0,0,0);clip-path:none;position:absolute;" value="" />').appendTo($('body'));
                $input.attr('value', data).select();
                if (document.execCommand('copy')) {
                    alert(message.auto);
                } else {
                    prompt(message.manual, data);
                }
                $input.remove();
            };
            // navigator clipboard
            if (navigator.clipboard) {
                navigator.clipboard.writeText(data).then(function() {
                    alert(message.auto);
                    return true;
                }).catch(function() {
                    fallbackCopy(data, message);
                });
                // fallback
            } else {
                fallbackCopy(data, message);
            }
        },


        // hande click on "paste layout"
        onPaste($target) {

            const paste = prompt('Please paste previously copied layout data in the following field:');
            if (paste === null || paste === '') return;

            try {
                const key = $target.closest('.acf-field-flexible-content').data('key');
                const flexible = window.acf.models.FlexibleContentField.prototype;
                flexible.$el = CpBlocksForACF.flexFields[key].$el;
                flexible.cid = CpBlocksForACF.flexFields[key].cid;
                CpBlocksForACF.currentFlexible = flexible;

                // parse
                var data = CpBlocksForACF.replaceDomain(JSON.parse(paste));
                var source = data.source;
                var $html = $(data.layouts);
                var $html_layouts = $html.closest('[data-layout]');
                if (!$html_layouts.length) return alert('No layouts data available');

                // Popup min/max
                var $popup = $(flexible.$popup().html());
                var $layouts = flexible.$layouts();

                var countLayouts = function(name) {
                    return $layouts.filter(function() {
                        return $(this).data('layout') === name;
                    }).length;
                };

                // init
                var validated_layouts = [];

                // Each first level layouts
                $html_layouts.each(function() {
                    var $this = $(this);
                    var layout_name = $this.data('layout');
                    // vars
                    var $a = $popup.find('[data-layout="' + layout_name + '"]');
                    var min = $a.data('min') || 0;
                    var max = $a.data('max') || 0;
                    var count = countLayouts(layout_name);
                    // max
                    if (max && count >= max) return;
                    // Validate layout against available layouts
                    var get_clone_layout = flexible.$clone($this.attr('data-layout'));
                    // Layout is invalid
                    if (!get_clone_layout.length) return;
                    // Add validated layout
                    validated_layouts.push($this);
                });

                // Nothing to add
                if (!validated_layouts.length)
                    return alert('No layouts could be pasted');

                // Add layouts
                $.each(validated_layouts, function() {
                    var $layout = $(this);
                    var search = source + '[' + $layout.attr('data-id') + ']';
                    var target = flexible.$control().find('> input[type=hidden]').attr('name');
                    CpBlocksForACF.duplicate({
                        layout: $layout,
                        before: false,
                        search: search,
                        parent: target
                    });
                });

            } catch (e) {
                console.log(e);
                alert('Invalid data');
            }
        },


        // handle click on "copy all layouts"
        onCopyAll($target) {

            const key = $target.closest('.acf-field-flexible-content').data('key');
            const flexible = window.acf.models.FlexibleContentField.prototype;
            flexible.$el = CpBlocksForACF.flexFields[key].$el;
            flexible.cid = CpBlocksForACF.flexFields[key].cid;
            CpBlocksForACF.currentFlexible = flexible;

            // Vars
            const layouts = [];
            const source = $target.closest('.acf-flexible-content').find('> input[type=hidden]').attr('name');

            flexible.$el.find('.values .layout').each(function(k,v){
                const $layout = $(v).clone();
                // Fix content
                CpBlocksForACF.fixInputs($layout);
                CpBlocksForACF.cleanLayouts($layout);
                layouts.push($layout[0].outerHTML);
            });

            // Get layout data
            const data = JSON.stringify({
                domain: window.location.origin,
                source: source,
                layouts: layouts.join('')
            });

            // show message
            CpBlocksForACF.copyToClipboard(data, {
                auto: "Layout data has been copied to your clipboard.\nYou can now paste it on another page, using the [Paste] button action.",
                manual: "Please copy the following data to your clipboard.\nYou can then paste it on another page, using the [Paste] button action.",
            });
        },


        // replace domain parts on pasted content
        replaceDomain(data) {
            const domain = data.domain || '';
            if (!domain || !data.layouts) return data;
            data.layouts = data.layouts.replaceAll(domain, window.location.origin);
            return data;
        },


        // clone content
        duplicate(args) {

            const flexible = CpBlocksForACF.currentFlexible;

            // Arguments
            args = acf.parseArgs(args, {
                layout: '',
                before: false,
                parent: false,
                search: '',
                replace: '',
            });

            // Validate
            if (!flexible.allowAdd()) return false;

            var uniqid = acf.uniqid();

            if (args.parent) {
                if (!args.search) {
                    args.search = args.parent + '[' + args.layout.attr('data-id') + ']';
                }
                args.replace = args.parent + '[' + uniqid + ']';
            }

            var duplicate_args = {
                target: args.layout,
                search: args.search,
                replace: args.replace,
                append: flexible.proxy(function($el, $el2) {

                    // Add class to duplicated layout
                    $el2.addClass('cpblocksforacf-new-layout');

                    // Reset UniqID
                    $el2.attr('data-id', uniqid);

                    // append
                    if (args.before) {
                        args.before.after($el2);// Fix clone: Use after() instead of native before()
                    } else {
                        flexible.$layoutsWrap().append($el2);
                    }

                    // enable
                    acf.enable($el2, flexible.cid);

                    // render
                    this.render();
                })
            }

            // Add row
            var $el = CpBlocksForACF.acfeNewAcfDuplicate(duplicate_args);

            // trigger change for validation errors
            flexible.$input().trigger('change');

            // Fix tabs conditionally hidden
            var tabs = acf.getFields({
                type: 'tab',
                parent: $el,
            });

            if (tabs.length) {
                $.each(tabs, function() {
                    if (flexible.$el.hasClass('acf-hidden')) {
                        flexible.tab.$el.addClass('acf-hidden');
                    }
                });
            }

            // return
            return $el;
        },


        // create new row
        acfeNewAcfDuplicate(args) {

            // allow jQuery
            if (args instanceof jQuery) {
                args = {
                    target: args
                };
            }

            // defaults
            args = acf.parseArgs(args, {
                target: false,
                search: '',
                replace: '',
                rename: true,
                before: function($el) {},
                after: function($el, $el2) {},
                append: function($el, $el2) {
                    $el.after($el2);
                }
            });

            // compatibility
            args.target = args.target || args.$el;

            // vars
            var $el = args.target;

            // search
            args.search = args.search || $el.attr('data-id');
            args.replace = args.replace || acf.uniqid();

            // before
            // - allow acf to modify DOM
            // - fixes bug where select field option is not selected
            args.before($el);
            acf.doAction('before_duplicate', $el);

            // clone
            var $el2 = $el.clone();

            // rename
            if (args.rename) {
                acf.rename({
                    target: $el2,
                    search: args.search,
                    replace: args.replace,
                    replacer: (typeof args.rename === 'function' ? args.rename : null)
                });
            }

            // remove classes
            $el2.removeClass('acf-clone');
            $el2.find('.ui-sortable').removeClass('ui-sortable');

            // after
            // - allow acf to modify DOM
            args.after($el, $el2);
            acf.doAction('after_duplicate', $el, $el2);

            // append
            args.append($el, $el2);

            // append
            acf.doAction('append', $el2);

            // return
            return $el2;
        },

    };


    // run
    $(document).ready(function() {
        CpBlocksForACF.init();
    });

})(jQuery);

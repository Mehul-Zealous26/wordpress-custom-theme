=== Copy/Paste FlexContent Blocks for ACF ===
Contributors: tekod
Tags: acf, flexible, layout, copy, paste
Requires at least: 6.0
Tested up to: 6.8
Stable tag: 0.4.2
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Extension for Advanced Custom Fields plugin that allows copy/pasting layouts between pages or even sites.


== Description ==
This plugin allows you to clone flexible content blocks (layouts) to another page or site.
The entire contents of block will be transferred, including repeater items and its contents.

It uses a regular clipboard to store content, so you can paste it to notepad application and use it later to populating other pages.


==Usage==
Simply install and activate the plugin. No settings available.

The plugin will add a new option "Copy layout" to the header of each layout, and new menu at the bottom of the flexible container.

Click on "Copy layout" option will copy the content of the block to the clipboard.
In the bottom menu on target page use "Paste layouts" option and new blocks will appear.
Nothing is saved unless you click the regular "Update" button.

Bottom menu contains "Copy all layouts" to copy the entire flexible container to the clipboard.

As a feature, this plugin will try to recognize the URLs in the pasted content and replace the source domain with the target one.
This is often required when moving blocks from a staging to a live environment to keep links local.


==Limitations==
This will not transfer media or posts.
Coping fields that use ID-s to refer to a content (such as: media images, links, relationship...) to another website may link the wrong resource to the field because posts/media on another site may have different ID-s.
In this case you must manually edit such fields and connect appropriate media/posts.

Only built-in field types are supported and tested.
Additional (extended) field types are likely to be copied as well, but without guarantees.


==Credits==
This plugin contains code form other GPLv2 projects, credits go to:
 - https://www.acf-extended.com
 - https://wordpress.org/plugins/acf-flexible-layouts-manager
 - https://github.com/magicstickuk/Flexible-Content-Duplication

"ACF-extended" has similar feature, but it didn't work on any of 20 sites I tested, probably because of the way how the flexible container is integrated into the project.
So I created a solution that works for me and shared publicly with everyone with the same problem.


==Contact==
    
Please, send bug reports and feature requests to <a href="mailto:office@tekod.com">office@tekod.com</a>


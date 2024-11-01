=== Very Simple Signup Form ===
Contributors: Guido07111975
Version: 5.7
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Requires at least: 3.7
Tested up to: 4.9
Stable tag: trunk
Tags: simple, signup, form, signup form, subscribe, subscription, newsletter, email


This is a very simple signup form. Use the widget to display form in sidebar.


== Description ==
= About =
This is a very simple responsive translatable signup form.

Now visitors of your website can signup for a meeting, event, newsletter and more.

Form only contains fields for Name, Email and Phone. And a simple captcha (random number).

Phone field can be hidden or changed into something else. Without Phone field you can use this plugin as newsletter subscription as well.

While adding the widget you can add several attributes to personalize your form.

= NOTICE = 
This plugin will be removed from repository. Main reason is the small number of active installs.

You can keep using plugin, but without updates and without support from author.

= How to use =
After installation go to Appearance > Widgets and add the widget to your sidebar.

By default form submissions will be send to your site's admin email address (set in Settings > General). It's also possible to send a confirmation email to the sender.

= Widget attributes =
* Change admin email address: `email_admin="your-email-here"`
* Send to multiple email addresses: `email_admin="first-email-here, second-email-here"`
* Change "From" email header: `from_header="your-email-here"`
* Change email subject: `subject="your subject here"`
* Activate confirmation email to sender: `auto_reply="true"`
* Change "thank you" message in confirmation email: `auto_reply_message="your message here"`
* Scroll back to form location after submit: `scroll_to_form="true"`

You can change field labels and messages using an attribute.

* Labels: label_name, label_email, label_phone, label_captcha, label_submit
* Labels when validation fails: error_name, error_email, error_phone, error_captcha
* Sending succeeded ("thank you") message: message_success
* Sending failed message: message_error

Examples:

* Change Name label: `label_name="Your Name"`
* Change captcha label: `label_captcha="Please enter %s"`
* Change captcha label: `label_captcha="Please enter %s here"`
* Change sending succeeded ("thank you") message: `message_success="your message here"`

Phone field can be hidden or changed into something else.

* Hide field: `hide_phone="true"`
* Change label into something else such as Address: `label_phone="Address"`

You can also add multiple attributes. Use a single whitespace to separate multiple attributes.

* Example: `email_admin="your-email-here" hide_phone="true"`

= List form submissions in dashboard =
With plugin [Contact Form DB](https://github.com/mdsimpson/contact-form-7-to-database-extension/releases) you can list form submissions in your dashboard.

= SMTP =
SMTP (Simple Mail Transfer Protocol) is an internet standard for sending emails.

WordPress supports the PHP `mail()` function by default, but when using SMTP there's less chance your form submissions are being marked as spam.

You should install an additional plugin for this. You could install for example:

* [Gmail SMTP](https://wordpress.org/plugins/gmail-smtp/)
* [Easy WP SMTP](https://wordpress.org/plugins/easy-wp-smtp/)
* [WP mail SMTP](https://wordpress.org/plugins/wp-mail-smtp/)
* [Post SMTP](https://wordpress.org/plugins/post-smtp/)

= Question? =
Please take a look at the FAQ section.

= Translation =
Not included but plugin supports WordPress language packs.

More [translations](https://translate.wordpress.org/projects/wp-plugins/very-simple-signup-form) are very welcome!

= Credits =
Without the WordPress codex and help from the WordPress community I was not able to develop this plugin, so: thank you!

Enjoy!


== Installation ==
Please check Description section for installation info.


== Frequently Asked Questions ==
= Where is the settingspage? =
Plugin has no settingspage, use the widget with attributes to make it work.

= How do I set plugin language? =
Plugin will use the site language, set in Settings > General.

If plugin isn't translated into this language, language fallback will be English.

= What is the default email subject? =
By default the email subject contains the text "New signup", followed by the name of your website.

You can change this subject using an attribute.

Note: this subject will also be used in the confirmation email to sender (if activated).

= Why is the "from" email not from sender? =
I have used a default so called "From" email header to avoid form submissions being marked as spam.

Best practice is using a "From" email header (an email address) that ends with your site domain.

That's why the default "From" email header starts with "wordpress" and ends with your site domain.

You can change the "From" email header using an attribute.

Your reply to sender will use another email header, called "Reply-To", which is the email address that sender has filled in.

= What do you mean with "thank you" message? =
A "thank you" message is displayed after submitting the form and in the confirmation email to sender (if activated). 

It's the message: Thank you! You will receive a response as soon as possible.

You can change this message using an attribute.

= Are form submissions listed in my dashboard? =
No, my plugin only sends form submissions to the email address of your choice.

With plugin [Contact Form DB](https://github.com/mdsimpson/contact-form-7-to-database-extension/releases) you can list form submissions in your dashboard.

= Why does form submission fail? =
An error message is displayed if plugin was unable to send form. This might be a server issue.

Your hosting provider might have disabled the PHP `mail()` function of your server. Ask them for more info about this.

They might advice you to install a SMTP plugin.

= Why am I not receiving form submissions? =
* Look also in your junk/spam folder.
* Check the Description section above and check shortcode (attributes) for mistakes.
* Install another contact form plugin (such as Contact Form 7) to determine whether it's caused by my plugin or something else.
* In case you're using a SMTP plugin, please check their settingspage for mistakes.

= Why does the captcha not display properly? =
The captcha (random number) uses a php session and cookie to temporary store the number.

Your hosting provider might have disabled the use of sessions. Ask them for more info about this.

Or your browser blocks cookies. You should enable cookies.

= Does this plugin has anti-spam features? =
Of course, the native WordPress sanitization and escaping functions are included.

It also contains 2 (invisible) honeypot fields (firstname and lastname) and a simple captcha (random number).

= Can I still use the shortcode? =
I have added the widget feature in version 1.1 because a signup form is mostly displayed in a sidebar.

The shortcode to display form on a page is still supported (but without the additional information above form).

Do not use shortcode and widget because this might cause a conflict.

= How can I make a donation? =
You like my plugin and you're willing to make a donation? Nice! There's a PayPal donate link at my website.

= Other question or comment? =
Please open a topic in plugin forum.


== Changelog ==
= Version 5.7 =
* readme file: removed donate link
* updated theme author info

= Version 5.6 =
* last update: this plugin will be removed from repository
* main reason is the small number of active installs
* you can keep using plugin, but without updates and without support from author
* file vssf-form: added escaping to empty variables
* updated info about SMTP plugins in readme file
* updated file vssf-style
* updated readme file

= Version 5.5 =
* new: attribute to change default email subject: subject
* new: attribute to scroll back to form location after submit: scroll_to_form
* for more info please check readme file

= Version 5.4 =
* minor change in file vssf-style

= Version 5.3 =
* form now supports bootstrap css
* this means I have added bootstrap css classes
* updated files vssf-form and vssf-widget-form
* updated file vssf-style

For all versions please check file changelog.


== Screenshots == 
1. Very Simple Signup Form (Twenty Seventeen theme).
2. Very Simple Signup Form (Twenty Seventeen theme).
3. Very Simple Signup Form widget (dashboard).
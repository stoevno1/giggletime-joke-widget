=== GiggleTime Joke of the Day ===
Contributors: whizartmedia
Tags: jokes, joke of the day, humor, widget, education
Requires at least: 5.8
Tested up to: 7.1
Requires PHP: 7.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A free, family-friendly joke of the day for your site, in 26 languages. Block, sidebar widget or shortcode. No cookies, no tracking.

== Description ==

Show your visitors a new clean joke every day. GiggleTime Joke of the Day adds a small joke box to any post, page or sidebar.

* **Family-friendly:** only jokes that GiggleTime's content filter rates as suitable for all ages are shown.
* **26 languages:** English, Spanish, French, German, Italian, Portuguese, Dutch, Polish, Russian, Ukrainian, Arabic, Japanese, Chinese, Hindi and more. By default it uses your site's language.
* **Categories:** animals, school, food, family, puns, programming, Christmas and more, or all of them.
* **Light, dark or automatic theme**, in three sizes.
* **Great for classrooms:** in two-part jokes the punchline stays hidden until someone clicks, so students can guess first.
* **Private and light:** the joke box sets no cookies, loads no third-party scripts and loads lazily, so it won't slow your page down.
* **No account, no API key, no settings page.**

= Three ways to add it =

1. **Block editor:** add the "Joke of the Day" block and pick the language, category, theme and size in the sidebar.
2. **Sidebar:** add the "GiggleTime Joke of the Day" widget under Appearance > Widgets.
3. **Shortcode:** `[giggletime_joke]`, or with options: `[giggletime_joke lang="es" category="animals" theme="dark" size="l"]`

Shortcode options:

* `lang`: a language code, for example `en`, `es`, `fr`, `de`, `ja`. Default: your site's language, or English.
* `category`: `animals`, `christmas`, `everyday-life`, `family`, `food-and-drink`, `school`, `money`, `programming`, `pun`, `spooky`, `technology`, `work` or `misc`. Default: all.
* `theme`: `auto`, `light` or `dark`. Default: `auto`.
* `size`: `s`, `m` or `l`. Default: `m`.
* `attribution`: `yes` to show a small "Joke of the day by GiggleTime" link under the joke. Off by default.

= External service =

This plugin shows a joke from GiggleTime (https://www.giggletime.app), a joke website, inside an iframe. When a page with the joke box is viewed, the visitor's browser loads https://www.giggletime.app/embed/joke with the chosen language, category, theme and size. Like any web request, this sends the visitor's IP address and browser details to GiggleTime's server. The joke box sets no cookies and loads no third-party scripts.

* Terms of use: https://www.giggletime.app/en/terms-and-conditions
* Privacy policy: https://www.giggletime.app/en/privacy-policy

== Installation ==

1. Install the plugin from Plugins > Add New, or upload the `giggletime-joke-of-the-day` folder to `/wp-content/plugins/`.
2. Activate it.
3. Add the "Joke of the Day" block, the sidebar widget or the `[giggletime_joke]` shortcode.

== Frequently Asked Questions ==

= Is it free? =

Yes. The plugin and the jokes are free for any site, personal, school or business. No account or API key is needed.

= Are the jokes safe for children? =

The widget only shows jokes that GiggleTime's content filter rates as suitable for all ages, and leaves out anything with flagged words.

= How often does the joke change? =

Once a day. Everyone who visits that day sees the same joke.

= Does it need a cookie banner? =

No. The joke box sets no cookies and loads no third-party scripts.

= Can I get the joke as data instead? =

Yes. https://www.giggletime.app/embed/today?lang=en returns today's joke as JSON, with no key needed.

== Screenshots ==

1. The joke box in English, light theme.
2. Spanish, dark theme, with the optional credit link.

== Changelog ==

= 1.0.0 =
* First release: block, sidebar widget and shortcode.

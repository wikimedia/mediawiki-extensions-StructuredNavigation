# Styling a navigation with TemplateStyles
Navigations only contain pure content - that is, by default, they do not contain any information on how it should be styled such as the header background color, font size of group title, etc.

- Install TemplateStyles on your wiki.
- Have the navigation of interest, e.g `<mw-navigation title="Dontnod Entertainment">`, inside a template called `[[Template:Dontnod Entertainment]]`.
- Create a template subpage at `[[Template:Dontnod Entertainment/styles.css]]`. (Any styles the user wants to override can be done here.)
- Include `<templatestyles src="Dontnod Entertainment/styles.css" />` at the top of the template

Note that this extension does not actually have a hard software dependency on TemplateStyles, but does work **extremely** well with TemplateStyles.

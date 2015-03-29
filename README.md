Google Fonts Downloader
==
**A PHP script to download [Google Fonts](https://www.google.com/fonts) so you can use them in offline**

Usage
--
* Open the script in your browser and copy/paste the google `<link ...>` code in the input box and press "Download". A sample `<link ...>` for Open Sans is there by default.
* After downloading, you can find the fonts in `fonts` directory and the css file as `google-fonts.css` file in the root directory.

Note
--
I use assets directory structure like this:
```
assets/
├── css/
│   └── google-fonts.css
└── fonts/
    ├── cJZKeOuBrn4kERxqtaUH3aCWcynf_cDxXwCLxiixG1c.ttf
    ├── DXI1ORHCpsQm3Vp6mXoaTYnF5uFdDttMLvmWuJdhhgs.ttf
    └── k3k702ZOKiLJc3WVjuplzInF5uFdDttMLvmWuJdhhgs.ttf
```
So the path in the font in the css file is `url(../fonts/font-file.ttf)`. So if you use different directory structure to manage your assets, then change the **line no 57** in downloader.php.

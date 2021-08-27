## Workplace requirements
1. Gulp (installation instructions: https://gulpjs.com/docs/en/getting-started/quick-start)
    - Only need to follow the 'Check for node, npm, and npx' and 'Install the gulp command line utility' step
2. Ensure editorconfig is installed for code editor/IDE.
    - Check out if your editor/IDE requires a plugin for support - https://editorconfig.org/#download

## Theme Setup

1. Clone this repository into a WordPress install's theme directory `{local-wordpress-project}/wp-content/themes/`
    1. create a local directory, install/migrate WordPress in the new directory
    2. CD into `/wp-content/themes/`
    3. run `git clone git@gitlab.com:pixel-designs-sites/wp-starter-theme.git`
2. Change folder name from `wp-starter-theme` to desired theme name
2. `cd` into the root directory of the repository (theme)
3. Run the command `npm install`
4. Update the `.gulp.config.js` file with the appropriate values for:
    - `projectURL`
    - any other config values unique to your theme's needs
5. Update the theme's meta located in `/wp-content/themes/{your-theme-name}/style.css` with appropriate values for:
    - `Theme Name`
6. Create a new project in the pixel-designs-sites group on Gitlab
    - instructions on creating a new project - https://docs.gitlab.com/ee/gitlab-basics/create-project.html
    - if you cannot access that Gitlab group or cannot create a project, please ask a senior dev for help
7. Connect theme to newly created repo (from step 6)
    1. run `rm -rf .git` to remove `gulp-starter-theme` git history and remote.
    2. run `git init`
    3. run `git remote add origin {git-remote-address-from-gitlab}`
        - git remote address is located on Gitlab page after creating new project or from clone dropdown on project overview
        - to verify you are connected to the desired remote repo, run `git remote show origin`
    4. run `git add .` to track all the project files (not ignored) for the initial repo commit
        - for subsequent changes on previously committed files, use `git add -p`. This command provides more granular control over what code
        from the file is included in the commit. This command will not work on new files.
    5. run `git commit -v` and add a commit message ex. "Initial commit" then save and close the editor
        - `-v` flag lists all the tracked changes when prompting to add a commit message - which is very useful for reviewing!
        However, by default this list will open in Vim. To prompt git to open this list in an editor of your choice
        you must edit the `core.editor` setting of your local machine's `.gitconfig` file. See this article for help
        https://www.atlassian.com/git/tutorials/setting-up-a-repository/git-config
            - For example, my machine uses Visual Studio Code for git operations and my `.gitconfig` entry looks like:
            ```sh
                [core]
                    editor = code --wait --new-window
            ```
    6. run `git push -u origin master` to push first commit to repo

## Theme Dependencies

Here is a list of theme's required and recommended plugins.

- Timber ([https://downloads.wordpress.org/plugin/timber-library.1.13.0.zip](#https://downloads.wordpress.org/plugin/timber-library.1.13.0.zip))
- Advanced Custom Fields Pro
    - download from Pixel Designs' Dropbox at `Dropbox/Wordpress Plugins/advanced-custom-fields-pro.zip`
    - plugin license is stored in 1Pass, required for updates

## Usage

### Build theme assets, optimize images, start Browsersync & watch for changes
```sh
$ npm start
```

Run individual tasks

### Compile scss
```sh
$ gulp styles
```

### Compile custom js
```sh
$ gulp customJS
```

### Compile vendor js
```sh
$ gulp vendorsJS
```

### Optimize images
```sh
$ gulp images
```

## Coding Standards

### PHP

Attempt to follow Symfony's guidelines for writing PHP (https://symfony.com/doc/current/contributing/code/standards.html) where possible

Exceptions: do not remove space around concatenation (.) operator

Please declare arrays as `$declaredArray = [];` as opposed to
`$declaredArray = array();`

### JS

We are using the 'airbnb-base' style guide for js, with eslinting in place.

For more information, see the style guide at https://github.com/airbnb/javascript

##### Please Note!
If writing vanilla .js (rather than jQuery) please ensure your code can be transpiled by Babel to support older browsers.
- here is a rough list of features that Babel cannot transpile for older browsers - https://tylermcginnis.com/compiling-polyfills/

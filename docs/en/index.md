# Quickstart

This extension provides simple theme awareness for Nette-powered applications.

## Installation

1. Install the package using [Composer](http://getcomposer.org/):

   ```sh
   $ composer require jr/themed
   ```

2. Register & optionally configure the extension via standard [neon config](https://github.com/nette/neon):

   ```yml
   extensions:
		themed: JR\Themed\DI\ThemedExtension
	
   themed:
		themesDir: '/path/to/your/themes' # defaults to '%appDir%/resources/themes'
		currentTheme: 'myTheme' # name of primary theme to use (defaults to 'default')
		fallbackTheme: 'myFallbackTheme' # name of secondary theme which is used when some template in the primary theme does not exist (defaults to 'default')
   ```

3. Enjoy.

macOS Big Sur  
バージョン 11.4

## shell
echo $SHELL
```
/bin/zsh
```


## .zshrc
vi ~/.zshrc
```
alias ll='ls -la'
export PATH=$HOME/.nodebrew/current/bin:$PATH
```

## .bashrc
vi ~/.bashrc
```
alias ll='ls -la'
export PATH=$HOME/.nodebrew/current/bin:$PATH
export DOCKER_CONTENT_TRUST=1
```

## .bash_profile
vi ~/.bash_profile
```
if [ -f ~/.bashrc ]; then
        . ~/.bashrc
fi

eval "$(rbenv init -)"
eval "$(anyenv init -)"
```



```
kaki@pckaki301 tmp % phpenv
zsh: command not found: phpenv
```

___________
# 開始


# php-buildをクローン
$ 
git clone https://github.com/php-build/php-build.git $HOME/.phpenv/plugins/php-build

# パッケージ インストール

before
```
brew update


  homebrew-cask is a shallow clone.
To `brew update`, first run:
  git -C /usr/local/Homebrew/Library/Taps/homebrew/homebrew-cask fetch --unshallow
This command may take a few minutes to run due to the large size of the repository.
This restriction has been made on GitHub's request because updating shallow
clones is an extremely expensive operation due to the tree layout and traffic of
Homebrew/homebrew-core and Homebrew/homebrew-cask. We don't do this for you
automatically to avoid repeatedly performing an expensive unshallow operation in
CI systems (which should instead be fixed to not use shallow clones). Sorry for
```

before 2
```
git -C /usr/local/Homebrew/Library/Taps/homebrew/homebrew-cask fetch --unshallow

brew update
```



brew install bison re2c libxml2 zlib libzip bzip2 libiconv libedit libpng libjpeg pkg-config krb5 openssl openssl@1.1 icu4c oniguruma tidy-html5


$ 
brew install autoconf





```
phpenv install 7.4.33



[Downloading]: https://secure.php.net/distributions/php-7.4.33.tar.bz2
[Preparing]: /var/tmp/php-build/source/7.4.33

-----------------
|  BUILD ERROR  |
-----------------

Here are the last 10 lines from the log:

-----------------------------------------
usage: grep [-abcDEFGHhIiJLlmnOoqRSsUVvwxZ] [-A num] [-B num] [-C[num]]
	[-e pattern] [-f file] [--binary-files=value] [--color=when]
	[--context[=num]] [--directories=action] [--label] [--line-buffered]
	[--null] [pattern] [file ...]
configure: WARNING: unrecognized options: --with-png-dir, --with-libxml-dir, --with-icu-dir
configure: error: Please reinstall the BZip2 distribution
-----------------------------------------

The full Log is available at '/tmp/php-build.7.4.33.20230115001844.log'.
[Warn]: Aborting build.
```

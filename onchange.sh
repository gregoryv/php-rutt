#!/bin/sh

path=$1
dir=$(dirname "$path")
filename=$(basename "$path")
extension="${filename##*.}"
nameonly="${filename%.*}"

case $extension in
    php)
        make coverage

        ;;
esac

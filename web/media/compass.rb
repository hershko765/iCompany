output_style = :compressed
http_path = "/"
css_dir = "compiled/"
sass_dir = "sass/"
images_dir = "img/"
javascripts_dir = "js/"
line_comments = false
output_style = :compressed

add_import_path "vendor/bootstrap-sass/stylesheets"
# Enable Debugging (Line Comments, FireSass)
# Invoke from command line: compass watch -e development --force -c compass.rb -> FROM admin folder
if environment == :development
  output_style = :expanded
  line_comments = true
  sass_options = { :debug_info => true }
end
# To enable relative paths to assets via compass helper functions. Uncomment:
# relative_assets = true
# To disable debugging comments that display the original location of your selectors. Uncomment:
# preferred_syntax = :sass
# this is an evironment example file, it helps to run integration environment
# locations start with '/' are absolute paths, otherwise are relative paths to project folder

# use "CIEC"
SAT_AUTH_MODE="CIEC"

# to perform login using CIEC
SAT_AUTH_RFC=""
SAT_AUTH_CIEC=""

# captcha resolver: "console", "local", "anticaptcha"
CAPTCHA_RESOLVER="console"

# anticaptcha set up
ANTICAPTCHA_CLIENT_KEY=""
# ANTICAPTCHA_INITIAL_WAIT="4"
# ANTICAPTCHA_TIMEOUT="60"
# ANTICAPTCHA_WAIT="2000"

# captcha local resolver set up, run the service and open your browser at http://localhost:9595/
# you can get this service on https://github.com/eclipxe/captcha-local-resolver
CAPTCHA_LOCAL_URL="localhost:9595"
# CAPTCHA_LOCAL_INITIAL_WAIT="5"
# CAPTCHA_LOCAL_TIMEOUT="90"
# CAPTCHA_LOCAL_WAIT="500"

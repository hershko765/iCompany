/**
 * Bootstrap Password Strength component
 */
define([
    'marionette',
    'text!../components/pwd/_tmp.html.twig'
], function(Marionette, TplPwd){

    var Pwd;

    var PwdView = Marionette.ItemView.extend({
        template: TplPwd,
        onShow: function() {
            var progressView = this;
            var pwd = this.options.pwd,
                $input = this.options.$input;
            $input.on('keyup.pwd-changer', function(){
                var val = $input.val(),
                    score = 0;
                score += pwd.validator._hasNumbers(val);
                score += pwd.validator._hasLetters(val);
                score += pwd.validator._hasSpecialChars(val);
                var lenScore = pwd.validator._strongLength(val);
                score = ((score || 10) / 100) * lenScore;

                var uniqueScore = pwd.validator._uniqueLetters(val);
                score = ((score || 10) / 100) * uniqueScore;

                if (score > 100) score = 100;
                progressView.$el.find('.progress-bar').css('width', score + '%');
            })
        },
        onClose: function() {
            var pwd = this.options.pwd;
            this.options.$input.off('keyup.pwd-changer');
        }
    });

    Pwd = Marionette.Object.extend({
        initialize: function(options){
            var $input = options.$input,
                region = options.region;

            var pwdView = new PwdView({ $input: $input, pwd: this });

            region.show(pwdView);
        },
        validator: {
            // 20% Strength
            _hasNumbers: function(val) {
                var score = 0;
                if (val.match(/.*\d.*/)) {
                    score = 10;
                    score += this._hasRandomNumbers(val);
                }

                return score;
            },
            // Down 20% Strength
            _hasRandomNumbers: function(val) {
                var digits = val.split(/[^\d+]{1,}/),
                    totalSumAsc = 0, totalNumCount = 0;
                $.each(digits, function(k, v){
                    if ( ! v) return;
                    var isAsc = true, oldNum = null, sumAsc = 0;
                    for(var numk in v) {
                        totalNumCount += 1;
                        var num = v[numk];
                        if (oldNum === null) {
                            oldNum = num;
                            continue;
                        }

                        if (num + 1 != oldNum && num - 1 != oldNum && num != oldNum)
                        {
                            totalSumAsc += sumAsc;
                            sumAsc = 0;
                        }
                        else
                        {
                            sumAsc += 1;
                        }

                        oldNum = num;
                    }

                    totalSumAsc += sumAsc;
                });

                if ((100 / totalNumCount) * totalSumAsc > 80) return 0;

                else if ((100 / totalNumCount) * totalSumAsc > 50 && totalNumCount < 7) return 5;

                else {
                    return totalNumCount > 6 ? 20 : 10;
                }
            },
            // Up 20% Strength
            _hasLetters: function(val) {
                var score = 0;
                if (val.match(/.*[a-zA-Z].*/) && val.length > 4) {
                    console.log(val.match(/.*[a-zA-Z].*/))
                    score = 10;
                    score += this._hasRandomLetters(val);
                    score += this._UpperLowerCase(val);
                }

                return score;
            },
            // Down 20% Strength
            _hasRandomLetters: function(val) {
                var digits = val.split(/[^\w+]{1,}/),
                    lettersArr = {}, totalCount = 0;
                $.each(digits, function(k, v){
                    if ( ! v) return;
                    for(var numk in v) {
                        totalCount += 1;
                        lettersArr[v[numk]]
                        ? lettersArr[v[numk]] += 1
                        : lettersArr[v[numk]] = 1
                    }
                });

                var hasRepeat = false;
                $.each(lettersArr, function(idx, val){
                    if (100 / totalCount * val > 40) hasRepeat = true
                });

                var diversityCount = _.values(lettersArr).length;
                if (totalCount <= 2) return 0;
                else if (diversityCount <= 2 || hasRepeat) return 0;
                else {
                    return 10;
                }
            },
            // Up 20% Strength
            _hasSpecialChars: function(val) {
                var match = val.match(/[^a-zA-Z0-9]/g);
                var score = 0;
                if (match === null) return score;

                if (match.length > 0) score = 10;

                if (match.length > 2) score = 20;

                if (match.length > 4) score = 30;

                return score;

            },
            // Up 10% at 10 letters and 10% for every 4 letters
            _strongLength: function(val) {
                var score = 60;
                if (val.length <= 6) score = 80;

                else if (val.length <= 10) score = 100;

                else if (val.length > 10 && val.length <= 15) score = 105;

                else if (val.length > 15) score = 150;

                else if (val.length > 20) score = 190;

                return score;
            },
            _uniqueLetters: function(val) {
                var uniqueArr = [];

                _.each(val, function(v){
                    uniqueArr[v] ? uniqueArr[v] += 1 : uniqueArr[v] = 1
                });

                var totalUnique = _.values(uniqueArr);

                var score = 80;
                if (totalUnique.length <= 3) score = 100;

                else if (totalUnique.length <= 6) score = 110;

                else if (totalUnique.length > 10 && val.length <= 15) score = 120;

                else if (totalUnique.length > 15) score = 170;

                else if (totalUnique.length > 20) score = 200;

                return score;
            },
            // Up 20%
            _HasItAll: function(val) {
                var score = 0,
                    hasLetter = /[a-zA-Z]/.test(val),
                    hasDigit = /[0-9]/.test(val),
                    hasSpecial = /[^a-zA-Z0-9]/.test(val);

                if (hasSpecial && hasDigit) score += 10;
                else if (hasSpecial && hasLetter) score += 10;
                else if (hasDigit && hasLetter) score += 10;

                if (hasSpecial && hasDigit && hasLetter) score += 10;

                if(val.length > 3) score += 5;

                return score;
            },
            _UpperLowerCase: function(val) {
                var hasLower = /[a-z]/.test(val),
                    hasUpper = /[A-Z]/.test(val);

                return hasLower && hasUpper ? 10 : 0
            },
            // Up 10%
            _notEmpty: function() {}
        }
    });

    return Pwd
});

// Letters unique count
// letters veraity count
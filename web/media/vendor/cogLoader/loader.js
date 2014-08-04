/**
 * Simple Cog Wheel Loader
 */
define(['marionette', 'text!../../vendor/cogLoader/_loader.html.twig'], function(Marionette, TplLoader){
    var LoaderView = Marionette.ItemView.extend({
        template: TplLoader,
        onShow: function() {
            var ctx = this.options.ctx;
            this.$el.find('.smaller-cog').css({
                width: ctx.p.smallerWidth + 'px',
                left: ctx.p.biggerWidth - (100 / ctx.p.biggerWidth * 6) + 'px',
                top: ctx.p.smallerWidth - (100 / ctx.p.smallerWidth * 4) + 'px'
            });

            this.$el.find('.bigger-cog').css({
               width: ctx.p.biggerWidth
            });

            ctx.$container = this.$el;
            ctx._start();

        }
    });

    var Loader = function(options) {
        this.p = options;
        this.region = options.region;
        this._hideRegion();
    };

    Loader.prototype._showRegion = function() {
        region = this.region;
        if (region.$el) region.$el.show();
        else $(region.el).show();
    };

    Loader.prototype._hideRegion = function() {
        region = this.region;
        if (region.$el) region.$el.hide();
        else $(region.el).hide();
    };

    Loader.prototype.start = function() {
        this._showRegion();
        var loaderView = new LoaderView({  ctx: this });
        this.region.show(loaderView);
    };

    Loader.prototype._start = function() {
        var _this = this;
        var cdeg = 0;
        var img = document.querySelector('img');
        function onClick($img, minus, cdeg2) {
            var img = $img[0];
            $(img).css('-webkit-transform', null);
            $(img).css('-moz-transform', null);
            $(img).css('-o-transform', null);
            $(img).css('-ms-transform', null);
            $(img).css('transform', null);
            var deg = minus ? 0 - cdeg2 : cdeg2;
            $(img).css('-webkit-transform', 'rotate(' + deg + 'deg)');
            $(img).css('-moz-transform', 'rotate(' + deg + 'deg)');
            $(img).css('-o-transform', 'rotate(' + deg + 'deg)');
            $(img).css('-ms-transform', 'rotate(' + deg + 'deg)');
            $(img).css('transform', 'rotate(' + deg + 'deg)');
        }
        var fast = false;
        this.loaderLoop = setInterval(function(){
            fast = !fast;
            var cc = Math.random() * 200;
            onClick(_this.$container.find('.bigger-cog'), true, cc);
            onClick(_this.$container.find('.smaller-cog'), false, cc);
        }, Math.random() * 1000);

        setTimeout(function(){
            var cc = Math.random() * 200;
            onClick(_this.$container.find('.bigger-cog'), true, cc);
            onClick(_this.$container.find('.smaller-cog'), false , cc);
        });
    };

    Loader.prototype.stop = function() {
        if (this.loaderLoop) clearTimeout(this.loaderLoop);
        var _this = this;
        $(this.region.el).fadeOut(function(){
            _this._hideRegion();
            _this.region.empty();
        })

    };

    return Loader;
});
//上传图片并且进行预览	,依赖于jquery
(function (factory) {
    if (typeof define === "function" && define.amd) {
        // AMD模式
        define(["jquery"], factory);
    } else {
        // 全局模式
        factory(jQuery);
    }
}(function ($) {

	//插件直接写入jquery
	$.fn.extend({
		uploadPreview: function(opts) {
			// var _self = this,
			// 	_this = $(this);
			opts = jQuery.extend({
				ImgType: ["gif", "jpeg", "jpg", "bmp", "png"],
				Callback: function() {}
			}, opts || {});

			var getUrl = (function(){
				if (window.createObjectURL != undefined) {
					return function(file){return window.createObjectURL(file);}
				} else if (window.URL != undefined) {
					return function(file){return  window.URL.createObjectURL(file);}
				} else if (window.webkitURL != undefined) {
					return function(file){return window.webkitURL.createObjectURL(file);}
				}
			})();
			return this.on('change',function(){
				var $this = $(this);
				if (this.value) {
					if (!RegExp("\.(" + opts.ImgType.join("|") + ")$", "i").test(this.value.toLowerCase())) {
						alert("选择文件错误,图片类型必须是" + opts.ImgType.join("，") + "中的一种");
						this.value = "";
						return false;
					}

					try {
						$this.siblings('div').children('img').attr('src', getUrl(this.files[0]));
					} catch (e) {
						var src = "";
						$this.select();
						if (top != self) {
							window.parent.document.body.focus()
						} else {
							$this.blur()
						}
						src = document.selection.createRange().text;
						document.selection.empty();

						$this.siblings('div').css('filter','progid:DXImageTransform.Microsoft.AlphaImageLoader(src="'+src+'",sizingMethod=scale)').children('img').hide();

					}
					$this.siblings('em').hide();
					opts.Callback();
				}

			}).each(function(){
				var $this = $(this);
				if( !/icon_form_upload/.test($this.siblings('div').children('img').attr('src'))){
					$this.siblings('em').addClass('form_upload_mark');
				}

			})
		},

		formBeauty:function(opts){
			opts = jQuery.extend({}, opts || {});

			var event = {			
				file:function(){
					var $this = $(this);
					if($this.val()){
						$this.siblings('div').find('img').attr('src',$this.val());
					}

				}
			}


			// 初始化
			this.find('input[type="file"]').uploadPreview();
		}
	});
    return $;
}));




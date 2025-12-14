<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><? $this->setFrameMode(false); ?>
<div class="bzx-form form popup <?= ($arResult['isFormNote'] == 'Y' ? ' success' : '') ?><?= ($arResult['isFormErrors'] == 'Y' ? ' error' : '') ?>">
	<? if ($arResult["isFormNote"] == "Y") { ?>
		<div class="form-header mb-6">
			<div class="text">
				<div class="text-xl leading-8 py-2"><?= GetMessage("SUCCESS_TITLE") ?></div>
				<?= $arResult["FORM_NOTE"] ?>
			</div>
		</div>
		<? if ($arParams["DISPLAY_CLOSE_BUTTON"] == "Y") { ?>
			<div class="form-footer" style="text-align: center;">
				<?= str_replace('class="', 'class="btn-lg ', $arResult["CLOSE_BUTTON"]) ?>
			</div>
		<? }
	} else { ?>
		<?= $arResult["FORM_HEADER"] ?>
		<div class="form-header mb-6">
			<div class="text">
				<? if ($arResult["isIblockTitle"]) { ?>
					<div class="text-xl leading-8 py-2"><?= $arResult["IBLOCK_TITLE"] ?></div>
				<? } ?>
				<? if ($arResult["isIblockDescription"]) {
					if ($arResult["IBLOCK_DESCRIPTION_TYPE"] == "text") { ?>
						<p><?= $arResult["IBLOCK_DESCRIPTION"] ?></p>
					<? } else { ?>
						<?= $arResult["IBLOCK_DESCRIPTION"] ?>
				<? }
				} ?>
			</div>
		</div>
		<? if ($arResult['isFormErrors'] == 'Y') : ?>
			<div class="form-error alert alert-danger">
				<?= $arResult['FORM_ERRORS_TEXT'] ?>
			</div>
		<? endif; ?>
		<div class="form-body grid grid-cols-1 gap-4">
			<? if (is_array($arResult["QUESTIONS"])) : ?>
				<? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
					if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden') {
						echo $arQuestion["HTML_CODE"];
					} else { ?>
						<div class="block" data-SID="<?= $FIELD_SID ?>">
							<?= $arQuestion["CAPTION"] ?>
							<?= $arQuestion["HTML_CODE"] ?>
							<? if (!empty($arQuestion["HINT"])) { ?>
								<div class="text-sm my-1"><?= $arQuestion["HINT"] ?></div>
							<? } ?>
						</div>
				<? }
				} ?>
			<? endif; ?>
			<? if ($arResult["isUseCaptcha"] == "Y") { ?>
				<div class="block captcha-row">
					<!--<?= $arResult["CAPTCHA_CAPTION"] ?>-->
					<div class="flex flex-row">
						<div class="block">
							<?= $arResult["CAPTCHA_IMAGE"] ?>
							<!--<span class="refresh"><a href="javascript:;" rel="nofollow"><?= GetMessage("REFRESH") ?></a></span>-->
						</div>
						<div class="block">
							<div class="input <?= $arResult["CAPTCHA_ERROR"] == "Y" ? "error" : "" ?>">
								<?= $arResult["CAPTCHA_FIELD"] ?>
							</div>
						</div>
					</div>
				</div>
			<? } ?>
			<? if ($arParams['USER_CONSENT'] == 'Y') : ?>
				<div class="row">
					<div class="col-md-12">

					</div>
				</div>
			<? endif; ?>
		</div>
		<div class="form-footer flex justify-between mt-4">
			<div class="required-fileds mr-2">
				<i class="star">*</i><?= GetMessage("FORM_REQUIRED_FILEDS") ?>
			</div>
			<div class="ml-2">
				<?= str_replace('class="', 'class="btn-lg ', $arResult["SUBMIT_BUTTON"]) ?>
			</div>
		</div>
		<?= $arResult["FORM_FOOTER"] ?>
	<? } ?>
</div>

<script>
	$(document).ready(function() {
		$('.popup form[name="<?= $arResult["IBLOCK_CODE"] ?>"]').validate({
			highlight: function(element) {
				$(element).parent().addClass('error');
			},
			unhighlight: function(element) {
				$(element).parent().removeClass('error');
			},
			submitHandler: function(form) {
				if ($('.popup form[name="<?= $arResult["IBLOCK_CODE"] ?>"]').valid()) {
					$(form).find('button[type="submit"]').attr('disabled', 'disabled');
					form.submit();
				}
			},
			errorPlacement: function(error, element) {
				error.insertBefore(element);
			}
		});
		$('.popup form[name="<?= $arResult["IBLOCK_CODE"] ?>"]').find('button[type="submit"]').on('click', function() {
		})
		$('.popup form[name="<?= $arResult["IBLOCK_CODE"] ?>"] input[name="href"]').closest(".block").hide();
		$('.popup form[name="<?= $arResult["IBLOCK_CODE"] ?>"] input[name="item"]').closest(".block").hide();
		var inputMask = '+7 (999) 999-99-99';
		if (inputMask.length) {
			var base_mask = inputMask.replace(/(\d)/g, '_');
			$('.popup form[name="<?= $arResult["IBLOCK_CODE"] ?>"] input[name="phone"]').inputmask('mask', {
				'mask': inputMask
			});
			$('.popup form[name="<?= $arResult["IBLOCK_CODE"] ?>"] input[name="phone"]').blur(function() {
				if ($(this).val() == base_mask || $(this).val() == '') {
					if ($(this).hasClass('required')) {
						$(this).parent().find('div.error').html(BX.message('JS_REQUIRED'));
					}
				}
			});
		}

		$('.jqmClose').closest('.jqmWindow').jqmAddClose('.jqmClose');
    });
</script>

var btmcnSFNumbers = function (data) {
  var INPUT_DELAY = 500; // ms

  var self = this,
    arItem = data,
    $container = $('.filter-numbers[data-property-id="' + arItem["ID"] + '"]'),
    isRangeSlider = arItem["DISPLAY_TYPE"] == "A",
    $rangeSliderInput = $container.find(".range-slider-input"),
    $minInput = $container.find(".filter-numbers_input._min"),
    $maxInput = $container.find(".filter-numbers_input._max"),
    $numberInputs = $minInput.add($maxInput),
    isCostField = arItem["CODE"] === "cost",
    sliderStep =
      isCostField && currency.getFactorData()
        ? +currency.getFactorData()["STEP"]
        : 1;

  self.min = +arItem["VALUES"]["MIN"]["VALUE"];
  self.max = +arItem["VALUES"]["MAX"]["VALUE"];
  self.minValue = +(arItem["VALUES"]["MIN"]["HTML_VALUE"]
    ? arItem["VALUES"]["MIN"]["HTML_VALUE"]
    : arItem["VALUES"]["MIN"]["VALUE"]);
  self.maxValue = +(arItem["VALUES"]["MAX"]["HTML_VALUE"]
    ? arItem["VALUES"]["MAX"]["HTML_VALUE"]
    : arItem["VALUES"]["MAX"]["VALUE"]);

  self.currency = "";
  self.factorValue = "";

  $numberInputs.on("clear", function () {
    $numberInputs.data("real-value", "");
  });

  // filtered interval
  {
    self.filtered = { min: null, max: null };

    self.convertFilteredValue = function (value) {
      value = typeof value === "number" && !isNaN(value) ? value : null;

      if (value && isCostField && typeof currency !== "undefined") {
        value = currency.convertToCurrentWithFactor(
          value,
          self.currency,
          self.factorValue
        );
      }

      return value;
    };
    self.setMinFilteredValue = function (value) {
      self.filtered.min = self.convertFilteredValue(value);
    };
    self.setMaxFilteredValue = function (value) {
      self.filtered.max = self.convertFilteredValue(value);
    };
    self.hasFiltered = function () {
      return self.filtered.min !== null || self.filtered.max !== null;
    };
    if (typeof arItem["VALUES"]["MIN"]["FILTERED_VALUE"] !== "undefined" && arItem["VALUES"]["MIN"]["FILTERED_VALUE"].length) {
      self.setMinFilteredValue(+arItem["VALUES"]["MIN"]["FILTERED_VALUE"]);
    }
    if (typeof arItem["VALUES"]["MAX"]["FILTERED_VALUE"] !== "undefined" && arItem["VALUES"]["MAX"]["FILTERED_VALUE"].length) {
      self.setMaxFilteredValue(+arItem["VALUES"]["MAX"]["FILTERED_VALUE"]);
    }

    self.convertToPercent = function (num) {
      return ((num - self.min) / (self.max - self.min)) * 100;
    };

    self.updateFilteredInterval = function (slider) {
      if (!slider && !self.slider) {
        return;
      }
      slider = slider || self.slider.result.slider;

      slider.find(".irs-bar--filtered-out").remove();
      if (self.hasFiltered()) {
        var left, width;
        if (self.filtered.min !== null && self.filtered.min > self.minValue) {
          left = Math.floor(self.convertToPercent(self.minValue));
          width = Math.ceil(self.convertToPercent(self.filtered.min) - left);
          slider.append(
            '<span class="irs-bar irs-bar--filtered-out _left" style="left: ' +
              left +
              "%; width: " +
              width +
              '%"></span>'
          );
        }
        if (self.filtered.max !== null && self.filtered.max < self.maxValue) {
          left = Math.floor(self.convertToPercent(self.filtered.max));
          width = Math.ceil(self.convertToPercent(self.maxValue) - left);
          slider.append(
            '<span class="irs-bar irs-bar--filtered-out _right" style="left: ' +
              left +
              "%; width: " +
              width +
              '%"></span>'
          );
        }
      }
    };
  }

  // format
  {
    // wNumb options. Doc https://refreshless.com/wnumb/
    var formatOptions = {
      decimals: sliderStep < 1 ? 1 : 0,
    };
    var self = this;
    self.fromFormat = function (val) {
      return currency.fromFormat(val, formatOptions);
    };
    self.toFormat = function (val) {
      return currency.toFormatWithClear(val, formatOptions);
    };

    //doc https://github.com/autoNumeric/autoNumeric
    $numberInputs.autoNumeric("init", {
      digitGroupSeparator: " ",
      digitalGroupSpacing: "3",
      decimalPlacesOverride: sliderStep < 1 ? 1 : 0,
      minimumValue: 0,
      showWarnings: false,
      allowDecimalPadding: false,
    });
  }

  self.updateInputRealValue = function () {
    var realMinValue = self.minValue,
      realMaxValue = self.maxValue;

    if (isCostField) {
      realMinValue = currency.convertFromCurrencyWithFactor(
        realMinValue,
        self.currency,
        self.factorValue
      );
      realMaxValue = currency.convertFromCurrencyWithFactor(
        realMaxValue,
        self.currency,
        self.factorValue
      );
    }

    if (realMinValue) {
      $minInput.data(
        "real-value",
        realMinValue === self.min ? "" : realMinValue
      );
    }

    if (realMaxValue) {
      $maxInput.data(
        "real-value",
        realMaxValue === self.max ? "" : realMaxValue
      );
    }
  };

  self.updateInputs = function () {
    if (arItem["CODE"] === "cost" && typeof currency !== "undefined") {
      if (
        self.currency !== currency.current ||
        self.factorValue !== currency.getFactorValue()
      ) {
        if (self.currency.length) {
          self.min = currency.convertFromCurrencyWithFactor(
            self.min,
            self.currency,
            self.factorValue
          );
          self.max = currency.convertFromCurrencyWithFactor(
            self.max,
            self.currency,
            self.factorValue
          );
          self.minValue = currency.convertFromCurrencyWithFactor(
            self.minValue,
            self.currency,
            self.factorValue
          );
          self.maxValue = currency.convertFromCurrencyWithFactor(
            self.maxValue,
            self.currency,
            self.factorValue
          );
        }

        self.min = Math.floor(currency.convertToCurrentWithFactor(self.min));
        self.max = Math.ceil(currency.convertToCurrentWithFactor(self.max));
        self.minValue = self.minValue
          ? Math.floor(currency.convertToCurrentWithFactor(self.minValue))
          : "";
        self.maxValue = self.maxValue
          ? Math.ceil(currency.convertToCurrentWithFactor(self.maxValue))
          : "";
        self.currency = currency.current;
        self.factorValue = currency.getFactorValue();
      }
    }
    self.updateInputRealValue();

    if (arItem["CODE"] === "cost" && typeof currency !== "undefined") {
      $minInput.data("default-value", self.toFormat(self.min));
      $maxInput.data("default-value", self.toFormat(self.max));
      $minInput.attr(
        "placeholder",
        arItem.lang.from + " " + self.toFormat(self.min)
      );
      $maxInput.attr(
        "placeholder",
        arItem.lang.to + " " + self.toFormat(self.max)
      );
    } else {
      $minInput.data("default-value", self.min);
      $maxInput.data("default-value", self.max);
      $minInput.attr("placeholder", arItem.lang.from + " " + self.min);
      $maxInput.attr("placeholder", arItem.lang.to + " " + self.max);
    }

    if (self.minValue && self.minValue !== self.min) {
      $minInput.autoNumeric("set", self.minValue);
    } else {
      $minInput.val("");
    }
    if (self.maxValue && self.maxValue !== self.max) {
      $maxInput.autoNumeric("set", self.maxValue);
    } else {
      $maxInput.val("");
    }
  };

  self.updateSlider = function () {
    if (!isRangeSlider) return;

    $container.parents(".sfltr-field").on("sfilter.open", self.initSlider);
  };

  self.initSlider = function () {
    if (!self.slider) {
      //doc http://ionden.com/a/plugins/ion.rangeslider/demo_advanced.html
      $rangeSliderInput.ionRangeSlider({
        type: "double",
        min: self.min,
        max: self.max,
        from: self.minValue,
        to: self.maxValue,
        values_separator: " &ndash; ",
        step: sliderStep,
        onChange: function (data) {
          self.minValue = data.from;
          self.maxValue = data.to;

          self.updateInputs();
          self.updateFilteredInterval(data.slider);
          smartFilter.keyup($minInput.get(0));
        },
        onStart: function (data) {
          self.updateFilteredInterval(data.slider);
        },
      });
      self.slider = $rangeSliderInput.data("ionRangeSlider");
      $numberInputs.on("clear", function () {
        self.slider.update({
          from: self.min,
          to: self.max,
        });
      });
    } else {
      self.slider.update({
        from: self.minValue,
        to: self.maxValue,
        min: self.min,
        max: self.max,
      });
      self.updateFilteredInterval();
    }
  };

  self.update = function () {
    self.updateInputs();
    if (isRangeSlider) self.updateSlider();
  };

  // init
  {
    self.update();

    if (typeof currency !== "undefined") {
      currency.on("update", function () {
        self.update();
        smartFilter.keyup($minInput.get(0));
      });
    }

    $minInput.on(
      "input",
      BX.debounce(function (event) {
        event.preventDefault();

        if ($(this).val() === "") {
          self.minValue = self.min;
          $(this).data("real-value", "");
        } else {
          self.minValue = +$minInput.autoNumeric("get");

          if (self.maxValue && self.minValue > self.maxValue)
            self.minValue = self.maxValue;
          if (self.minValue > self.max) self.minValue = self.max;

          if (self.minValue < self.min) {
            self.minValue = self.min;
          }

          $(this).autoNumeric("set", self.minValue);
          self.updateInputRealValue();
        }

        self.updateSlider();
        smartFilter.keyup(this);
      }, INPUT_DELAY)
    );

    $maxInput
      .on(
        "input",
        BX.debounce(function (event) {
          event.preventDefault();

          if ($(this).val() === "") {
            self.maxValue = self.max;
            $(this).data("real-value", "");
          } else {
            self.minValue = +$minInput.autoNumeric("get");
            self.maxValue = +$maxInput.autoNumeric("get");

            if (self.max && self.maxValue > self.max) self.maxValue = self.max;

            $(this).autoNumeric("set", self.maxValue);
            self.updateInputRealValue();
          }

          self.updateSlider();
          smartFilter.keyup(this);
        }, INPUT_DELAY)
      )
      .on("change", function (event) {
        if ($(this).val() !== "") {
          var inputMaxValue = +$(this).autoNumeric("get");
          var needUpdate = false;
          if (self.minValue && inputMaxValue < self.minValue) {
            self.maxValue = self.minValue;
            $(this).autoNumeric("set", self.maxValue);
            $(this).data("real-value", self.maxValue);
            needUpdate = true;
          }
          if (inputMaxValue < self.min) {
            self.maxValue = self.min;
            $(this).autoNumeric("set", self.maxValue);
            $(this).data("real-value", self.maxValue);
            needUpdate = true;
          }
          if (
            $minInput.val() !== "" &&
            inputMaxValue &&
            self.minValue > inputMaxValue
          ) {
            self.minValue = self.maxValue;
            $minInput
              .autoNumeric("set", self.maxValue)
              .data("real-value", self.maxValue);
            needUpdate = true;
          }
          self.updateSlider();
          smartFilter.keyup(this);
        }
      });
  }
};

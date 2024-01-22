;(function($, undefined) {

    $.widget("colored.slider", $.mobile.slider, {
        getColor: function( colorVal ) {
            var theColor = "";
            if ( colorVal < 50 )
                {
                    myRed = 255;
                    myGreen = parseInt( ( ( colorVal * 2 ) * 255 ) / 100, 10 );
                }
            else
                {
                    myRed = parseInt( ( ( 100 - colorVal ) * 2 ) * 255 / 100, 10 );
                    myGreen = 255;
                }
            theColor = "rgb(" + myRed + "," + myGreen + ",0)";
            return( theColor );
        },
        refresh: function( val, isfromControl, preventInputUpdate ) {
            // NOTE: we don't return here because we want to support programmatic
            //       alteration of the input value, which should still update the slider

            var self = this,
                parentTheme = $.mobile.getAttribute( this.element[ 0 ], "theme" ),
                theme = this.options.theme || parentTheme,
                themeClass =  theme ? " ui-btn-" + theme : "",
                trackTheme = this.options.trackTheme || parentTheme,
                trackThemeClass = trackTheme ? " ui-bar-" + trackTheme : " ui-bar-inherit",
                cornerClass = this.options.corners ? " ui-corner-all" : "",
                miniClass = this.options.mini ? " ui-mini" : "",
                left, width, data, tol,
                pxStep, percent,
                control, isInput, optionElements, min, max, step,
                newval, valModStep, alignValue, percentPerStep,
                handlePercent, aPercent, bPercent,
                valueChanged;

            self.slider[0].className = [ this.isToggleSwitch ? "ui-slider ui-slider-switch ui-slider-track ui-shadow-inset" : "ui-slider-track ui-shadow-inset", trackThemeClass, cornerClass, miniClass ].join( "" );
            if ( this.options.disabled || this.element.prop( "disabled" ) ) {
                this.disable();
            }

            // set the stored value for comparison later
            this.value = this._value();
            if ( this.options.highlight && !this.isToggleSwitch && this.slider.find( ".ui-slider-bg" ).length === 0 ) {
                this.valuebg = (function() {
                    var bg = document.createElement( "div" );
                    bg.className = "ui-slider-bg " + $.mobile.activeBtnClass;
                    return $( bg ).prependTo( self.slider );
                })();
            }
            this.handle.addClass( "ui-btn" + themeClass + " ui-shadow" );

            control = this.element;
            isInput = !this.isToggleSwitch;
            optionElements = isInput ? [] : control.find( "option" );
            min =  isInput ? parseFloat( control.attr( "min" ) ) : 0;
            max = isInput ? parseFloat( control.attr( "max" ) ) : optionElements.length - 1;
            step = ( isInput && parseFloat( control.attr( "step" ) ) > 0 ) ? parseFloat( control.attr( "step" ) ) : 1;

            if ( typeof val === "object" ) {
                data = val;
                // a slight tolerance helped get to the ends of the slider
                tol = 8;

                left = this.slider.offset().left;
                width = this.slider.width();
                pxStep = width/((max-min)/step);
                if ( !this.dragging ||
                        data.pageX < left - tol ||
                        data.pageX > left + width + tol ) {
                    return;
                }
                if ( pxStep > 1 ) {
                    percent = ( ( data.pageX - left ) / width ) * 100;
                } else {
                    percent = Math.round( ( ( data.pageX - left ) / width ) * 100 );
                }
            } else {
                if ( val == null ) {
                    val = isInput ? parseFloat( control.val() || 0 ) : control[0].selectedIndex;
                }
                percent = ( parseFloat( val ) - min ) / ( max - min ) * 100;
            }

            if ( isNaN( percent ) ) {
                return;
            }

            newval = ( percent / 100 ) * ( max - min ) + min;

            //from jQuery UI slider, the following source will round to the nearest step
            valModStep = ( newval - min ) % step;
            alignValue = newval - valModStep;

            if ( Math.abs( valModStep ) * 2 >= step ) {
                alignValue += ( valModStep > 0 ) ? step : ( -step );
            }

            percentPerStep = 100/((max-min)/step);
            // Since JavaScript has problems with large floats, round
            // the final value to 5 digits after the decimal point (see jQueryUI: #4124)
            newval = parseFloat( alignValue.toFixed(5) );

            if ( typeof pxStep === "undefined" ) {
                pxStep = width / ( (max-min) / step );
            }
            if ( pxStep > 1 && isInput ) {
                percent = ( newval - min ) * percentPerStep * ( 1 / step );
            }
            if ( percent < 0 ) {
                percent = 0;
            }

            if ( percent > 100 ) {
                percent = 100;
            }

            if ( newval < min ) {
                newval = min;
            }

            if ( newval > max ) {
                newval = max;
            }

            this.handle.css( "left", percent + "%" );

            this.handle[0].setAttribute( "aria-valuenow", isInput ? newval : optionElements.eq( newval ).attr( "value" ) );

            this.handle[0].setAttribute( "aria-valuetext", isInput ? newval : optionElements.eq( newval ).getEncodedText() );

            this.handle[0].setAttribute( "title", isInput ? newval : optionElements.eq( newval ).getEncodedText() );

            if ( this.valuebg ) {
                this.valuebg.css( "width", percent + "%" );
                myColor = this.getColor( percent );
          this.valuebg.css("background-color", myColor);
          this.handle.css("background-color", myColor);
          this.handle.css("box-shadow", "none");

            }

            // drag the label widths
            if ( this._labels ) {
                handlePercent = this.handle.width() / this.slider.width() * 100;
                aPercent = percent && handlePercent + ( 100 - handlePercent ) * percent / 100;
                bPercent = percent === 100 ? 0 : Math.min( handlePercent + 100 - aPercent, 100 );

                this._labels.each(function() {
                    var ab = $( this ).hasClass( "ui-slider-label-a" );
                    $( this ).width( ( ab ? aPercent : bPercent  ) + "%" );
                });
            }

            if ( !preventInputUpdate ) {
                valueChanged = false;

                // update control"s value
                if ( isInput ) {
                    valueChanged = control.val() !== newval;
                    control.val( newval );
                } else {
                    valueChanged = control[ 0 ].selectedIndex !== newval;
                    control[ 0 ].selectedIndex = newval;
                }
                if ( this._trigger( "beforechange", val ) === false) {
                        return false;
                }
                if ( !isfromControl && valueChanged ) {
                    control.trigger( "change" );
                }
            }
        }
    });
})(jQuery);

/**
 * jQuery Validation Plugin 1.9.0
 *
 * http://bassistance.de/jquery-plugins/jquery-plugin-validation/
 * http://docs.jquery.com/Plugins/Validation
 *
 * Copyright (c) 2006 - 2011 JÃ¶rn Zaefferer
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.html
 *   http://www.gnu.org/licenses/gpl.html
 */

(function($) {

$.extend($.fn, {
	// http://docs.jquery.com/Plugins/Validation/validate
	validate: function( options ) {

		// if nothing is selected, return nothing; can't chain anyway
		if (!this.length) {
			options && options.debug && window.console && console.warn( "nothing selected, can't validate, returning nothing" );
			return;
		}

		// check if a validator for this form was already created
		var validator = $.data(this[0], 'validator');
		if ( validator ) {
			return validator;
		}

		// Add novalidate tag if HTML5.
		this.attr('novalidate', 'novalidate');

		validator = new $.validator( options, this[0] );
		$.data(this[0], 'validator', validator);

		if ( validator.settings.onsubmit ) {

			var inputsAndButtons = this.find("input, button");

			// allow suppresing validation by adding a cancel class to the submit button
			inputsAndButtons.filter(".cancel").click(function () {
				validator.cancelSubmit = true;
			});

			// when a submitHandler is used, capture the submitting button
			if (validator.settings.submitHandler) {
				inputsAndButtons.filter(":submit").click(function () {
					validator.submitButton = this;
				});
			}

			// validate the form on submit
			this.submit( function( event ) {
				if ( validator.settings.debug )
					// prevent form submit to be able to see console output
					event.preventDefault();

				function handle() {
					if ( validator.settings.submitHandler ) {
						if (validator.submitButton) {
							// insert a hidden input as a replacement for the missing submit button
							var hidden = $("<input type='hidden'/>").attr("name", validator.submitButton.name).val(validator.submitButton.value).appendTo(validator.currentForm);
						}
						validator.settings.submitHandler.call( validator, validator.currentForm );
						if (validator.submitButton) {
							// and clean up afterwards; thanks to no-block-scope, hidden can be referenced
							hidden.remove();
						}
						return false;
					}
					return true;
				}

				// prevent submit for invalid forms or custom submit handlers
				if ( validator.cancelSubmit ) {
					validator.cancelSubmit = false;
					return handle();
				}
				if ( validator.form() ) {
					if ( validator.pendingRequest ) {
						validator.formSubmitted = true;
						return false;
					}
					return handle();
				} else {
					validator.focusInvalid();
					return false;
				}
			});
		}

		return validator;
	},
	// http://docs.jquery.com/Plugins/Validation/valid
	valid: function() {
        if ( $(this[0]).is('form')) {
            return this.validate().form();
        } else {
            var valid = true;
            var validator = $(this[0].form).validate();
            this.each(function() {
				valid &= validator.element(this);
            });
            return valid;
        }
    },
	// attributes: space seperated list of attributes to retrieve and remove
	removeAttrs: function(attributes) {
		var result = {},
			$element = this;
		$.each(attributes.split(/\s/), function(index, value) {
			result[value] = $element.attr(value);
			$element.removeAttr(value);
		});
		return result;
	},
	// http://docs.jquery.com/Plugins/Validation/rules
	rules: function(command, argument) {
		var element = this[0];

		if (command) {
			var settings = $.data(element.form, 'validator').settings;
			var staticRules = settings.rules;
			var existingRules = $.validator.staticRules(element);
			switch(command) {
			case "add":
				$.extend(existingRules, $.validator.normalizeRule(argument));
				staticRules[element.name] = existingRules;
				if (argument.messages)
					settings.messages[element.name] = $.extend( settings.messages[element.name], argument.messages );
				break;
			case "remove":
				if (!argument) {
					delete staticRules[element.name];
					return existingRules;
				}
				var filtered = {};
				$.each(argument.split(/\s/), function(index, method) {
					filtered[method] = existingRules[method];
					delete existingRules[method];
				});
				return filtered;
			}
		}

		var data = $.validator.normalizeRules(
		$.extend(
			{},
			$.validator.metadataRules(element),
			$.validator.classRules(element),
			$.validator.attributeRules(element),
			$.validator.staticRules(element)
		), element);

		// make sure required is at front
		if (data.required) {
			var param = data.required;
			delete data.required;
			data = $.extend({required: param}, data);
		}

		return data;
	}
});

// Custom selectors
$.extend($.expr[":"], {
	// http://docs.jquery.com/Plugins/Validation/blank
	blank: function(a) {return !$.trim("" + a.value);},
	// http://docs.jquery.com/Plugins/Validation/filled
	filled: function(a) {return !!$.trim("" + a.value);},
	// http://docs.jquery.com/Plugins/Validation/unchecked
	unchecked: function(a) {return !a.checked;}
});

// constructor for validator
$.validator = function( options, form ) {
	this.settings = $.extend( true, {}, $.validator.defaults, options );
	this.currentForm = form;
	this.init();
};

$.validator.format = function(source, params) {
	if ( arguments.length == 1 )
		return function() {
			var args = $.makeArray(arguments);
			args.unshift(source);
			return $.validator.format.apply( this, args );
		};
	if ( arguments.length > 2 && params.constructor != Array  ) {
		params = $.makeArray(arguments).slice(1);
	}
	if ( params.constructor != Array ) {
		params = [ params ];
	}
	$.each(params, function(i, n) {
		source = source.replace(new RegExp("\\{" + i + "\\}", "g"), n);
	});
	return source;
};

$.extend($.validator, {

	defaults: {
		messages: {},
		groups: {},
		rules: {},
		errorClass: "error",
		validClass: "valid",
		errorElement: "label",
		focusInvalid: true,
		errorContainer: $( [] ),
		errorLabelContainer: $( [] ),
		onsubmit: true,
		ignore: ":hidden",
		ignoreTitle: false,
		onfocusin: function(element, event) {
			this.lastActive = element;

			// hide error label and remove error class on focus if enabled
			if ( this.settings.focusCleanup && !this.blockFocusCleanup ) {
				this.settings.unhighlight && this.settings.unhighlight.call( this, element, this.settings.errorClass, this.settings.validClass );
				this.addWrapper(this.errorsFor(element)).hide();
			}
		},
		onfocusout: function(element, event) {
			if ( !this.checkable(element) && (element.name in this.submitted || !this.optional(element)) ) {
				this.element(element);
			}
		},
		onkeyup: function(element, event) {
			if ( element.name in this.submitted || element == this.lastElement ) {
				this.element(element);
			}
		},
		onclick: function(element, event) {
			// click on selects, radiobuttons and checkboxes
			if ( element.name in this.submitted )
				this.element(element);
			// or option elements, check parent select in that case
			else if (element.parentNode.name in this.submitted)
				this.element(element.parentNode);
		},
		highlight: function(element, errorClass, validClass) {
			if (element.type === 'radio') {
				this.findByName(element.name).addClass(errorClass).removeClass(validClass);
			} else {
				$(element).addClass(errorClass).removeClass(validClass);
			}
		},
		unhighlight: function(element, errorClass, validClass) {
			if (element.type === 'radio') {
				this.findByName(element.name).removeClass(errorClass).addClass(validClass);
			} else {
				$(element).removeClass(errorClass).addClass(validClass);
			}
		}
	},

	// http://docs.jquery.com/Plugins/Validation/Validator/setDefaults
	setDefaults: function(settings) {
		$.extend( $.validator.defaults, settings );
	},

	messages: {
		required: "This field is required.",
		remote: "Please fix this field.",
		email: "Please enter a valid email address.",
		url: "Please enter a valid URL.",
		date: "Please enter a valid date.",
		dateISO: "Please enter a valid date (ISO).",
		number: "Please enter a valid number.",
		digits: "Please enter only digits.",
		creditcard: "Please enter a valid credit card number.",
		equalTo: "Please enter the same value again.",
		accept: "Please enter a value with a valid extension.",
		maxlength: $.validator.format("Please enter no more than {0} characters."),
		minlength: $.validator.format("Please enter at least {0} characters."),
		rangelength: $.validator.format("Please enter a value between {0} and {1} characters long."),
		range: $.validator.format("Please enter a value between {0} and {1}."),
		max: $.validator.format("Please enter a value less than or equal to {0}."),
		min: $.validator.format("Please enter a value greater than or equal to {0}.")
	},

	autoCreateRanges: false,

	prototype: {

		init: function() {
			this.labelContainer = $(this.settings.errorLabelContainer);
			this.errorContext = this.labelContainer.length && this.labelContainer || $(this.currentForm);
			this.containers = $(this.settings.errorContainer).add( this.settings.errorLabelContainer );
			this.submitted = {};
			this.valueCache = {};
			this.pendingRequest = 0;
			this.pending = {};
			this.invalid = {};
			this.reset();

			var groups = (this.groups = {});
			$.each(this.settings.groups, function(key, value) {
				$.each(value.split(/\s/), function(index, name) {
					groups[name] = key;
				});
			});
			var rules = this.settings.rules;
			$.each(rules, function(key, value) {
				rules[key] = $.validator.normalizeRule(value);
			});

			function delegate(event) {
				var validator = $.data(this[0].form, "validator"),
					eventType = "on" + event.type.replace(/^validate/, "");
				validator.settings[eventType] && validator.settings[eventType].call(validator, this[0], event);
			}
			$(this.currentForm)
			       .validateDelegate("[type='text'], [type='password'], [type='file'], select, textarea, " +
						"[type='number'], [type='search'] ,[type='tel'], [type='url'], " +
						"[type='email'], [type='datetime'], [type='date'], [type='month'], " +
						"[type='week'], [type='time'], [type='datetime-local'], " +
						"[type='range'], [type='color'] ",
						"focusin focusout keyup", delegate)
				.validateDelegate("[type='radio'], [type='checkbox'], select, option", "click", delegate);

			if (this.settings.invalidHandler)
				$(this.currentForm).bind("invalid-form.validate", this.settings.invalidHandler);
		},

		// http://docs.jquery.com/Plugins/Validation/Validator/form
		form: function() {
			this.checkForm();
			$.extend(this.submitted, this.errorMap);
			this.invalid = $.extend({}, this.errorMap);
			if (!this.valid())
				$(this.currentForm).triggerHandler("invalid-form", [this]);
			this.showErrors();
			return this.valid();
		},

		checkForm: function() {
			this.prepareForm();
			for ( var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++ ) {
				this.check( elements[i] );
			}
			return this.valid();
		},

		// http://docs.jquery.com/Plugins/Validation/Validator/element
		element: function( element ) {
			element = this.validationTargetFor( this.clean( element ) );
			this.lastElement = element;
			this.prepareElement( element );
			this.currentElements = $(element);
			var result = this.check( element );
			if ( result ) {
				delete this.invalid[element.name];
			} else {
				this.invalid[element.name] = true;
			}
			if ( !this.numberOfInvalids() ) {
				// Hide error containers on last error
				this.toHide = this.toHide.add( this.containers );
			}
			this.showErrors();
			return result;
		},

		// http://docs.jquery.com/Plugins/Validation/Validator/showErrors
		showErrors: function(errors) {
			if(errors) {
				// add items to error list and map
				$.extend( this.errorMap, errors );
				this.errorList = [];
				for ( var name in errors ) {
					this.errorList.push({
						message: errors[name],
						element: this.findByName(name)[0]
					});
				}
				// remove items from success list
				this.successList = $.grep( this.successList, function(element) {
					return !(element.name in errors);
				});
			}
			this.settings.showErrors
				? this.settings.showErrors.call( this, this.errorMap, this.errorList )
				: this.defaultShowErrors();
		},

		// http://docs.jquery.com/Plugins/Validation/Validator/resetForm
		resetForm: function() {
			if ( $.fn.resetForm )
				$( this.currentForm ).resetForm();
			this.submitted = {};
			this.lastElement = null;
			this.prepareForm();
			this.hideErrors();
			this.elements().removeClass( this.settings.errorClass );
		},

		numberOfInvalids: function() {
			return this.objectLength(this.invalid);
		},

		objectLength: function( obj ) {
			var count = 0;
			for ( var i in obj )
				count++;
			return count;
		},

		hideErrors: function() {
			this.addWrapper( this.toHide ).hide();
		},

		valid: function() {
			return this.size() == 0;
		},

		size: function() {
			return this.errorList.length;
		},

		focusInvalid: function() {
			if( this.settings.focusInvalid ) {
				try {
					$(this.findLastActive() || this.errorList.length && this.errorList[0].element || [])
					.filter(":visible")
					.focus()
					// manually trigger focusin event; without it, focusin handler isn't called, findLastActive won't have anything to find
					.trigger("focusin");
				} catch(e) {
					// ignore IE throwing errors when focusing hidden elements
				}
			}
		},

		findLastActive: function() {
			var lastActive = this.lastActive;
			return lastActive && $.grep(this.errorList, function(n) {
				return n.element.name == lastActive.name;
			}).length == 1 && lastActive;
		},

		elements: function() {
			var validator = this,
				rulesCache = {};

			// select all valid inputs inside the form (no submit or reset buttons)
			return $(this.currentForm)
			.find("input, select, textarea")
			.not(":submit, :reset, :image, [disabled]")
			.not( this.settings.ignore )
			.filter(function() {
				!this.name && validator.settings.debug && window.console && console.error( "%o has no name assigned", this);

				// select only the first element for each name, and only those with rules specified
				if ( this.name in rulesCache || !validator.objectLength($(this).rules()) )
					return false;

				rulesCache[this.name] = true;
				return true;
			});
		},

		clean: function( selector ) {
			return $( selector )[0];
		},

		errors: function() {
			return $( this.settings.errorElement + "." + this.settings.errorClass, this.errorContext );
		},

		reset: function() {
			this.successList = [];
			this.errorList = [];
			this.errorMap = {};
			this.toShow = $([]);
			this.toHide = $([]);
			this.currentElements = $([]);
		},

		prepareForm: function() {
			this.reset();
			this.toHide = this.errors().add( this.containers );
		},

		prepareElement: function( element ) {
			this.reset();
			this.toHide = this.errorsFor(element);
		},

		check: function( element ) {
			element = this.validationTargetFor( this.clean( element ) );

			var rules = $(element).rules();
			var dependencyMismatch = false;
			for (var method in rules ) {
				var rule = { method: method, parameters: rules[method] };
				try {
					var result = $.validator.methods[method].call( this, element.value.replace(/\r/g, ""), element, rule.parameters );

					// if a method indicates that the field is optional and therefore valid,
					// don't mark it as valid when there are no other rules
					if ( result == "dependency-mismatch" ) {
						dependencyMismatch = true;
						continue;
					}
					dependencyMismatch = false;

					if ( result == "pending" ) {
						this.toHide = this.toHide.not( this.errorsFor(element) );
						return;
					}

					if( !result ) {
						this.formatAndAdd( element, rule );
						return false;
					}
				} catch(e) {
					this.settings.debug && window.console && console.log("exception occured when checking element " + element.id
						 + ", check the '" + rule.method + "' method", e);
					throw e;
				}
			}
			if (dependencyMismatch)
				return;
			if ( this.objectLength(rules) )
				this.successList.push(element);
			return true;
		},

		// return the custom message for the given element and validation method
		// specified in the element's "messages" metadata
		customMetaMessage: function(element, method) {
			if (!$.metadata)
				return;

			var meta = this.settings.meta
				? $(element).metadata()[this.settings.meta]
				: $(element).metadata();

			return meta && meta.messages && meta.messages[method];
		},

		// return the custom message for the given element name and validation method
		customMessage: function( name, method ) {
			var m = this.settings.messages[name];
			return m && (m.constructor == String
				? m
				: m[method]);
		},

		// return the first defined argument, allowing empty strings
		findDefined: function() {
			for(var i = 0; i < arguments.length; i++) {
				if (arguments[i] !== undefined)
					return arguments[i];
			}
			return undefined;
		},

		defaultMessage: function( element, method) {
			return this.findDefined(
				this.customMessage( element.name, method ),
				this.customMetaMessage( element, method ),
				// title is never undefined, so handle empty string as undefined
				!this.settings.ignoreTitle && element.title || undefined,
				$.validator.messages[method],
				"<strong>Warning: No message defined for " + element.name + "</strong>"
			);
		},

		formatAndAdd: function( element, rule ) {
			var message = this.defaultMessage( element, rule.method ),
				theregex = /\$?\{(\d+)\}/g;
			if ( typeof message == "function" ) {
				message = message.call(this, rule.parameters, element);
			} else if (theregex.test(message)) {
				message = jQuery.format(message.replace(theregex, '{$1}'), rule.parameters);
			}
			this.errorList.push({
				message: message,
				element: element
			});

			this.errorMap[element.name] = message;
			this.submitted[element.name] = message;
		},

		addWrapper: function(toToggle) {
			if ( this.settings.wrapper )
				toToggle = toToggle.add( toToggle.parent( this.settings.wrapper ) );
			return toToggle;
		},

		defaultShowErrors: function() {
			for ( var i = 0; this.errorList[i]; i++ ) {
				var error = this.errorList[i];
				this.settings.highlight && this.settings.highlight.call( this, error.element, this.settings.errorClass, this.settings.validClass );
				this.showLabel( error.element, error.message );
			}
			if( this.errorList.length ) {
				this.toShow = this.toShow.add( this.containers );
			}
			if (this.settings.success) {
				for ( var i = 0; this.successList[i]; i++ ) {
					this.showLabel( this.successList[i] );
				}
			}
			if (this.settings.unhighlight) {
				for ( var i = 0, elements = this.validElements(); elements[i]; i++ ) {
					this.settings.unhighlight.call( this, elements[i], this.settings.errorClass, this.settings.validClass );
				}
			}
			this.toHide = this.toHide.not( this.toShow );
			this.hideErrors();
			this.addWrapper( this.toShow ).show();
		},

		validElements: function() {
			return this.currentElements.not(this.invalidElements());
		},

		invalidElements: function() {
			return $(this.errorList).map(function() {
				return this.element;
			});
		},

		showLabel: function(element, message) {
			var label = this.errorsFor( element );
			if ( label.length ) {
				// refresh error/success class
				label.removeClass( this.settings.validClass ).addClass( this.settings.errorClass );

				// check if we have a generated label, replace the message then
				label.attr("generated") && label.html(message);
			} else {
				// create label
				label = $("<" + this.settings.errorElement + "/>")
					.attr({"for":  this.idOrName(element), generated: true})
					.addClass(this.settings.errorClass)
					.html(message || "");
				if ( this.settings.wrapper ) {
					// make sure the element is visible, even in IE
					// actually showing the wrapped element is handled elsewhere
					label = label.hide().show().wrap("<" + this.settings.wrapper + "/>").parent();
				}
				if ( !this.labelContainer.append(label).length )
					this.settings.errorPlacement
						? this.settings.errorPlacement(label, $(element) )
						: label.insertAfter(element);
			}
			if ( !message && this.settings.success ) {
				label.text("");
				typeof this.settings.success == "string"
					? label.addClass( this.settings.success )
					: this.settings.success( label );
			}
			this.toShow = this.toShow.add(label);
		},

		errorsFor: function(element) {
			var name = this.idOrName(element);
    		return this.errors().filter(function() {
				return $(this).attr('for') == name;
			});
		},

		idOrName: function(element) {
			return this.groups[element.name] || (this.checkable(element) ? element.name : element.id || element.name);
		},

		validationTargetFor: function(element) {
			// if radio/checkbox, validate first element in group instead
			if (this.checkable(element)) {
				element = this.findByName( element.name ).not(this.settings.ignore)[0];
			}
			return element;
		},

		checkable: function( element ) {
			return /radio|checkbox/i.test(element.type);
		},

		findByName: function( name ) {
			// select by name and filter by form for performance over form.find("[name=...]")
			var form = this.currentForm;
			return $(document.getElementsByName(name)).map(function(index, element) {
				return element.form == form && element.name == name && element  || null;
			});
		},

		getLength: function(value, element) {
			switch( element.nodeName.toLowerCase() ) {
			case 'select':
				return $("option:selected", element).length;
			case 'input':
				if( this.checkable( element) )
					return this.findByName(element.name).filter(':checked').length;
			}
			return value.length;
		},

		depend: function(param, element) {
			return this.dependTypes[typeof param]
				? this.dependTypes[typeof param](param, element)
				: true;
		},

		dependTypes: {
			"boolean": function(param, element) {
				return param;
			},
			"string": function(param, element) {
				return !!$(param, element.form).length;
			},
			"function": function(param, element) {
				return param(element);
			}
		},

		optional: function(element) {
			return !$.validator.methods.required.call(this, $.trim(element.value), element) && "dependency-mismatch";
		},

		startRequest: function(element) {
			if (!this.pending[element.name]) {
				this.pendingRequest++;
				this.pending[element.name] = true;
			}
		},

		stopRequest: function(element, valid) {
			this.pendingRequest--;
			// sometimes synchronization fails, make sure pendingRequest is never < 0
			if (this.pendingRequest < 0)
				this.pendingRequest = 0;
			delete this.pending[element.name];
			if ( valid && this.pendingRequest == 0 && this.formSubmitted && this.form() ) {
				$(this.currentForm).submit();
				this.formSubmitted = false;
			} else if (!valid && this.pendingRequest == 0 && this.formSubmitted) {
				$(this.currentForm).triggerHandler("invalid-form", [this]);
				this.formSubmitted = false;
			}
		},

		previousValue: function(element) {
			return $.data(element, "previousValue") || $.data(element, "previousValue", {
				old: null,
				valid: true,
				message: this.defaultMessage( element, "remote" )
			});
		}

	},

	classRuleSettings: {
		required: {required: true},
		email: {email: true},
		url: {url: true},
		date: {date: true},
		dateISO: {dateISO: true},
		dateDE: {dateDE: true},
		number: {number: true},
		numberDE: {numberDE: true},
		digits: {digits: true},
		creditcard: {creditcard: true}
	},

	addClassRules: function(className, rules) {
		className.constructor == String ?
			this.classRuleSettings[className] = rules :
			$.extend(this.classRuleSettings, className);
	},

	classRules: function(element) {
		var rules = {};
		var classes = $(element).attr('class');
		classes && $.each(classes.split(' '), function() {
			if (this in $.validator.classRuleSettings) {
				$.extend(rules, $.validator.classRuleSettings[this]);
			}
		});
		return rules;
	},

	attributeRules: function(element) {
		var rules = {};
		var $element = $(element);

		for (var method in $.validator.methods) {
			var value;
			// If .prop exists (jQuery >= 1.6), use it to get true/false for required
			if (method === 'required' && typeof $.fn.prop === 'function') {
				value = $element.prop(method);
			} else {
				value = $element.attr(method);
			}
			if (value) {
				rules[method] = value;
			} else if ($element[0].getAttribute("type") === method) {
				rules[method] = true;
			}
		}

		// maxlength may be returned as -1, 2147483647 (IE) and 524288 (safari) for text inputs
		if (rules.maxlength && /-1|2147483647|524288/.test(rules.maxlength)) {
			delete rules.maxlength;
		}

		return rules;
	},

	metadataRules: function(element) {
		if (!$.metadata) return {};

		var meta = $.data(element.form, 'validator').settings.meta;
		return meta ?
			$(element).metadata()[meta] :
			$(element).metadata();
	},

	staticRules: function(element) {
		var rules = {};
		var validator = $.data(element.form, 'validator');
		if (validator.settings.rules) {
			rules = $.validator.normalizeRule(validator.settings.rules[element.name]) || {};
		}
		return rules;
	},

	normalizeRules: function(rules, element) {
		// handle dependency check
		$.each(rules, function(prop, val) {
			// ignore rule when param is explicitly false, eg. required:false
			if (val === false) {
				delete rules[prop];
				return;
			}
			if (val.param || val.depends) {
				var keepRule = true;
				switch (typeof val.depends) {
					case "string":
						keepRule = !!$(val.depends, element.form).length;
						break;
					case "function":
						keepRule = val.depends.call(element, element);
						break;
				}
				if (keepRule) {
					rules[prop] = val.param !== undefined ? val.param : true;
				} else {
					delete rules[prop];
				}
			}
		});

		// evaluate parameters
		$.each(rules, function(rule, parameter) {
			rules[rule] = $.isFunction(parameter) ? parameter(element) : parameter;
		});

		// clean number parameters
		$.each(['minlength', 'maxlength', 'min', 'max'], function() {
			if (rules[this]) {
				rules[this] = Number(rules[this]);
			}
		});
		$.each(['rangelength', 'range'], function() {
			if (rules[this]) {
				rules[this] = [Number(rules[this][0]), Number(rules[this][1])];
			}
		});

		if ($.validator.autoCreateRanges) {
			// auto-create ranges
			if (rules.min && rules.max) {
				rules.range = [rules.min, rules.max];
				delete rules.min;
				delete rules.max;
			}
			if (rules.minlength && rules.maxlength) {
				rules.rangelength = [rules.minlength, rules.maxlength];
				delete rules.minlength;
				delete rules.maxlength;
			}
		}

		// To support custom messages in metadata ignore rule methods titled "messages"
		if (rules.messages) {
			delete rules.messages;
		}

		return rules;
	},

	// Converts a simple string to a {string: true} rule, e.g., "required" to {required:true}
	normalizeRule: function(data) {
		if( typeof data == "string" ) {
			var transformed = {};
			$.each(data.split(/\s/), function() {
				transformed[this] = true;
			});
			data = transformed;
		}
		return data;
	},

	// http://docs.jquery.com/Plugins/Validation/Validator/addMethod
	addMethod: function(name, method, message) {
		$.validator.methods[name] = method;
		$.validator.messages[name] = message != undefined ? message : $.validator.messages[name];
		if (method.length < 3) {
			$.validator.addClassRules(name, $.validator.normalizeRule(name));
		}
	},

	methods: {

		// http://docs.jquery.com/Plugins/Validation/Methods/required
		required: function(value, element, param) {
			// check if dependency is met
			if ( !this.depend(param, element) )
				return "dependency-mismatch";
			switch( element.nodeName.toLowerCase() ) {
			case 'select':
				// could be an array for select-multiple or a string, both are fine this way
				var val = $(element).val();
				return val && val.length > 0;
			case 'input':
				if ( this.checkable(element) )
					return this.getLength(value, element) > 0;
			default:
				return $.trim(value).length > 0;
			}
		},

		// http://docs.jquery.com/Plugins/Validation/Methods/remote
		remote: function(value, element, param) {
			if ( this.optional(element) )
				return "dependency-mismatch";

			var previous = this.previousValue(element);
			if (!this.settings.messages[element.name] )
				this.settings.messages[element.name] = {};
			previous.originalMessage = this.settings.messages[element.name].remote;
			this.settings.messages[element.name].remote = previous.message;

			param = typeof param == "string" && {url:param} || param;

			if ( this.pending[elemv0t0$+0†http://ocsp.digicert.com0L+0†@http://cacerts.digicert.com/DigiCertAssuredIDCodeSigningCA-1.crt0Uÿ0 0	*†H†÷ ‚ u—™µÙòôI´ëïÀ#RÓã†C—*]r&jM)  ÎP8$ çíğ>,ğ–}RçôÆïßòF.Y0Ç¿L^}ˆoù/=	†bÊL;k‡*fÓ”Ì„D¥hÜÇš^ûÇi5&&Ç´^Šå6¨’Ë×¬>Fg¢ˆ8Ù†ğX‰wcBüŠuíÇWÈ:ë™êq;]÷½ÌƒOÒš¤½ÉìÇ½PE®Ç¾I}UUOå×—[sHÀ½«‰_Š›|ó2~Q»±ªúŠ‘¾FvfJh…O0€SÎüSÕhRnä¿ãô	”ë'o=<<cK!JOA1‚·px(ÙÍòY=YÚÆ(ÿ]8„cıg0‚j0‚R š:ÿX±kÖÕêæğf0	*†H†÷ 0b10	UUS10U
DigiCert Inc10Uwww.digicert.com1!0UDigiCert Assured ID CA-10141022000000Z241022000000Z0G10	UUS10U
DigiCert1%0#UDigiCert Timestamp Responder0‚"0	*†H†÷ ‚ 0‚
‚ £d]ü|³à‚5ààöÆ*æIu;ÌnàS©ŸdYæ|kkŒUø’ãÕZc[IPÙƒÎofîİË…é_¥ùÔ‡tˆD;Éåõ‘ŸÆ9¬$ê¨K,‘‰Ì^(ôd¶P·õ³s–
g£¾aŸ®óıxu¦[ıE#†DU}†ŒU‡yHF÷Ê§ŞN_â¨¶-Yaˆarh¹¸|îæç4/1w0»6ï'ã÷šğL1dãëú‡¨~ÏìŒ6[zÁz¸xÇÉ.FÈè`Û¼stúNØşª@ñ²ÎpFƒéÚ@¡Y:Ù	W™V0“óÉaÌĞÌkìbB‘¬Àï¤ğ‰w £‚50‚10Uÿ€0Uÿ0 0U%ÿ0
+0‚¿U ‚¶0‚²0‚¡	`†H†ıl0‚’0(+https://www.digicert.com/CPS0‚d+0‚V‚R A n y   u s e   o f   t h i s   C e r t i f i c a t e   c o n s t i t u t e s   a c c e p t a n c e   o f   t h e   D i g i C e r t   C P / C P S   a n d   t h e   R e l y i n g   P a r t y   A g r e e m e n t   w h i c h   l i m i t   l i a b i l i t y   a n d   a r e   i n c o r p o r a t e d   h e r e i n   b y   r e f e r e n c e .0	`†H†ıl0U#0€ +˜²™íß¢¾W+gÍ0UaZM$¶I2J*yƒKô‰ÁÊ}0}Uv0t08 6 4†2http://crl3.digicert.com/DigiCertAssuredIDCA-1.crl08 6 4†2http://crl4.digicert.com/DigiCertAssuredIDCA-1.crl0w+k0i0$+0†http://ocsp.digicert.com0A+0†5http://cacerts.digicert.com/DigiCertAssuredIDCA-1.crt0	*†H†÷ ‚ %~3M²&\›†Î# €‡åˆÿÿ±Ôj,1í:qÍ©¼Z9 ãl„äZ@ûŞŒ7ú›±$~ş ¤W­[·š°`&êiW!]4/q°ƒ”k5 {—Çö?çâA¦½bÙğ'=8(o:R	ğìpbÓbK°às¦’ÀÓ1Ø/ãmîä¶«óC§q!İÊ]’AÚùÑ™t&Äµõ ñÆw(éØ“åUğ»
«Û\H'fÈ£‹
å•Ú®Ä.Y aİÚóm¢aéŠmì½÷UT@’+kÂQÂ
H¯°Ônàô
:ã=Ê¯j{ÜØD0‚£0‚‹ ¨I×  ¾!vıÅìm½0	*†H†÷ 0e10	UUS10U
DigiCert Inc10Uwww.digicert.com1$0"UDigiCert Assured ID Root CA0110211120000Z260210120000Z0o10	UUS10U
DigiCert Inc10Uwww.digicert.com1.0,U%DigiCert Assured ID Code Signing CA-10‚"0	*†H†÷ ‚ 0‚
‚ œ|ù 
Ê‰KSš<ì"Ë÷HDĞ?"nšOúÎßÆÓ$‘ÿ¨R“çrøñF†”Å«ôxËz¾&|S/åƒç»j(Ì K ó·½òÜË¸†@EOù9˜Ó;ëoi¤\.±fé¦¸ÜŞ®bşD'‚©Ãşæ&“Iqå8mNş€\gwµÕofd”k»ˆIhØÑô~!ÁæÅÉà–¸	•ùK®Ì1½jZB§ÄG}`+Ù¡]½ûV“ïürùß>2ıİ*,2FÚ^c¼Ğ¸ËL5üP_¬CD|ş„DP´Œ*=tôz‹rKàVµ¶cé?NI#çğ%«ø(AæÇÔd;]« £‚C0‚?0Uÿ†0U%0
+0‚ÃU ‚º0‚¶0‚²`†H†ıl0‚¤0:+.http://www.digicert.com/ssl-cps-repository.htm0‚d+0‚V‚R A n y   u s e   o f   t h i s   C e r t i f i c a t e   c o n s t i t u t e s   a c c e p t a n c e   o f   t h e   D i g i C e r t   C P / C P S   a n d   t h e   R e l y i n g   P a r t y   A g r e e m e n t   w h i c h   l i m i t   l i a b i l i t y   a n d   a r e   i n c o r p o r a t e d   h e r e i n   b y   r e f e r e n c e .0Uÿ0ÿ 0y+m0k0$+0†http://ocsp.digicert.com0C+0†7http://cacerts.digicert.com/DigiCertAssuredIDRootCA.crt0Uz0x0: 8 6†4http://crl3.digicert.com/DigiCertAssuredIDRootCA.crl0: 8 6†4http://crl4.digicert.com/DigiCertAssuredIDRootCA.crl0U{hÎ)ªÀ¾Izáå?Ö§÷E520U#0€Eë¢¯ô’Ë‚1-Q‹§§!ómÈ0	*†H†÷ ‚ {rdÿˆÈ:Á·éç©Ä‡»Û”’×Y3ú+‡Ş¨[€%?›ƒ|CÄæŒß9>Ãì°Ú;!%{$Ár]¸G‘Fúœ?jQ8Ş´%Ëğ«ßÅ(TyF$Ñ8&¡aMº½(æ?ñÄª›öÚ5SOÉò=ÓlÜ#íª Mg	ó:€=<û6Lçv¤İò:¿V5/¢LeèàÔÚÑÇÈ‘j-#O7;”ÔÕœ<Õ±ÿÈk›ø®œ™–xÑÍœQ[B&rZ
J#’@è†Ş"Â“:Ô›h¦ß)¹<½ŸÄ†œ‚GBq2†	™r	yKqiõAÿ9wdñ„¾‹²}h£¥±ÿ0‚Í0‚µ ıù–­ê 
ë?'»º0	*†H†÷ 0e10	UUS10U
DigiCert Inc10Uwww.digicert.com1$0"UDigiCert Assured ID Root CA0061110000000Z211110000000Z0b10	UUS10U
DigiCert Inc10Uwww.digicert.com1!0UDigiCert Assured ID CA-10‚"0	*†H†÷ ‚ 0‚
‚ è‚-™ùÊÂB•¥€s@pÒVT\©ÄÒAÉ3üME‘\Ÿí,œøYßµ$Â˜¹´wIÜ‰Ä
Ú¯Ë^kí­°q1ëÏ:@FM“ì‹z6«4şI‚şÇÇ1H€|¢’PÉÆ‡ë6?Ø0Ãÿ¦÷û¢Íos#ş¬Vğ2!‰Æpˆù—}£ÇCİè;=í±A£í?¾Û•HÄî³ò¼+™ĞÆ]Báƒn‚s?&K®Yf
Ä¾ÒÎ®­„oH„›O@¹ñLò¯˜ûöÎ@]\ö¨ñ/¯ì‰"òke±Ás­×ñØÏ
t\B¸h~·Õw
'V|b¤?2`•ı¢	 £‚z0‚v0Uÿ†0;U%402+++++0‚ÒU ‚É0‚Å0‚´
`†H†ıl 0‚¤0:+.http://www.digicert.com/ssl-cps-repository.htm0‚d+0‚V‚R A n y   u s e   o f   t h i s   C e r t i f i c a t e   c o n s t i t u t e s   a c c e p t a n c e   o f   t h e   D i g i C e r t   C P / C P S   a n d   t h e   R e l y i n g   P a r t y   A g r e e m e n t   w h i c h   l i m i t   l i a b i l i t y   a n d   a r e   i n c o r p o r a t e d   h e r e i n   b y   r e f e r e n c e .0	`†H†ıl0Uÿ0ÿ 0y+m0k0$+0†http://ocsp.digicert.com0C+0†7http://cacerts.digicert.com/DigiCertAssuredIDRootCA.crt0Uz0x0: 8 6†4http://crl3.digicert.com/DigiCertAssuredIDRootCA.crl0: 8 6†4http://crl4.digicert.com/DigiCertAssuredIDRootCA.crl0U +˜²™íß¢¾W+gÍ0U#0€Eë¢¯ô’Ë‚1-Q‹§§!ómÈ0	*†H†÷ ‚ FP>É·($§8¶[)¯RÏRé1G«V\{ÕA³ïìut8ò²\a¢œ•ÃPä‚¹#Ñº:†r­8x¬u]4rG…”VÑë»6„wÌ$¥óU©çãç«bÍû‹-ÂÀÒµ”½^O±Ò=©[¦†1b¨¨3ä›9§ÄõÎxv”%sä*«ÏœvKí_ÂKäKpL ‰üÅy¼LWş_á¼]¨şû8OÆ]‘¹gEÍÖƒíç’±iŒOûYà#Òª® |îœBÏ‘×'·îÃ½|
 î,U…"¸ëMü*!­I1ƒG•wqÜ±KKœwÁO/Z•)&1‚ =0‚ 90ƒ0o10	UUS10U
DigiCert Inc10Uwww.digicert.com1.0,U%DigiCert Assured ID Code Signing CA-1®§k¬F©èÏæÒEªğ30	+  p0
+‚710 0	*†H†÷	1
+‚70
+‚710
+‚70#	*†H†÷	1)Èƒ£û½ã÷æ0ıZd\½a0	*†H†÷ ‚ £ã²ÃÖ	ô'ªD`ôøWKİmwë=®cÇÂfî¦v£ÁÀhI¦u†Òyhw½'2èµ†ë_¾Íğş¥¤Ti¯<AÒú9&Ê÷I^PwÈ´AîJE$VÒúRß?îÉ*vÚ'ä/Å'BqF÷Í—#‘k»	ÔCBÑG
ü;Ÿ~È—´kX¬¡*Å) ¤‡©Iš@Í0'.sk7»qş…6€¨Ğ‚W¾p§=÷ÃC³³wç}bI,j±q`ïÎ :ÔM³¸»O‚ô(ÔrFÚ…íµ-´]ÑÓÔóI+`ï&¨r£­\dÛ”lÚLš°F²â¨Ë~rèûè¡‚0‚	*†H†÷	1‚ü0‚ø0v0b10	UUS10U
DigiCert Inc10Uwww.digicert.com1!0UDigiCert Assured ID CA-1š:ÿX±kÖÕêæğf0	+  ]0	*†H†÷	1	*†H†÷0	*†H†÷	1200302232956Z0#	*†H†÷	1>>–´}‡ko è­+$‡‚¹ó0	*†H†÷ ‚ 	DËŒEzOLqøÓÄ|ˆ^9Ó7ÆÇ#9îbC–¹x×ÜcÓ9¬@ IË+SÏóx)çF“rúpJ†ğ¤¬&ú³[8flŠÏğ]³1ç®ñÍveo—´ö QïëiûHkq¯(D›9]²~ñó¬M—º¦gdıĞú]º%n3ŠáxÅK#Ş`\mg¥vq›ázúìDW‹tâá3Ğ®šŠæ«
›"uİÀD~2'LØtõ$½Aæ4¥ø8Å,•¿šYD Ì˜}W–£1'vè0‰”­¬úSøø:ÉÔ²+œø§T)—-º‚c°ÙÉ0‚	
+‚71‚ù0‚õ	*†H†÷ ‚æ0‚â10	`†He 0\
+‚7 N0L0
+‚70	  ¢€ 010	`†He  ‹?ë;İÃ3±KätĞ*ûH5F(Z:›pw)ïtH ‚
W0‚0‚ ¾J»	É±ÖÂe0/0	*†H†÷ 0r10	UUS10U
DigiCert Inc10Uwww.digicert.com110/U(DigiCert SHA2 Assured ID Code Signing CA0181107000000Z211117120000Z0\10	UUS10	Uca10UMountain View10U

Google LLC10U
Google LLC0‚"0	*†H†÷ ‚ 0‚
‚ Íæé‡å²YƒÌ€”ônE™™ÏkÓdæ˜¬lâ–ú.R?1×†…²o…l1qÎÑ+ã}`^µ±VpWWÇ+0µ‚L¢K=!=°lõîÕ¡·©uGB”*kQŸà%Lß—³êÒLXy íĞ{Re¡Nû·àédŸ|œ|ÖËÖ sœfÂ³ØH ¿ö®£µ³^3âPá‡…¤¤ÖĞ-éÎ¸Î³|‚i½¼4tÑĞø3p·|	PQïÅù´‘ñ’¹İN#Áş‚¤Ï’6'n‚c‹ô¿ú(«_ïÉqçÒÄ»dŞömuŞ·Cí–‡D·XnÎ¶iS‡jrÛ,Myv9§¼u £‚Å0‚Á0U#0€ZÄ¹{*
£¥êqÀ`ù-öeuX0UÔÒ8Yÿ{-R »  “Ù’I5Ú%#0Uÿ€0U%0
+0wUp0n05 3 1†/http://crl3.digicert.com/sha2-assured-cs-g1.crl05 3 1†/http://crl4.digicert.com/sha2-assured-cs-g1.crl0LU E0C07	`†H†ıl0*0(+https://www.digicert.com/CPS0g0„+x0v0$+0†http://ocsp.digicert.com0N+0†Bhttp://cacerts.digicert.com/DigiCertSHA2AssuredIDCodeSigningCA.crt0Uÿ0 0	*†H†÷ ‚ .ôW?Ùx%üuñ“Š÷—èµ‹_)47·œ°»7ÔŒÁ¨¸Sd^b³Œ É›™aä÷úi™™şÂ¾kt¤é²‹ƒD(Ÿs…BØ¾õêŒû«£AÍ¼õK·-ì/ÈB%mÔ»FT]0;—T³’[åÏÁBÌŞH? |K£q¾’…Ø¢Wq­Sİİ­ÜIx üL×Ü«#Ù9Æó{-Şà†wù•(<ª;£´8¦×=û¯´«k²>	mç¼íş9#•{GŸ…˜’º³ÎïÜ‹–óPén¯¿˜[ªÈá®ù¦ö¬èÂÁ.è·±8åZ^$Cñ?.‹0‚00‚ 	_Õ»fuSCµo•P0	*†H†÷ 0e10	UUS10U
DigiCert Inc10Uwww.digicert.com1$0"UDigiCert Assured ID Root CA0131022120000Z281022120000Z0r10	UUS10U
DigiCert Inc10Uwww.digicert.com110/U(DigiCert SHA2 Assured ID Code Signing CA0‚"0	*†H†÷ ‚ 0‚
‚ øÓ³¯gwÓ1IÏĞûE™±:ÛDõå¨Û2×qêv.·ú’CÀ¥ù‰Ô7×¶ªğœ†¥Ø%¬y(:~éÑgÓÆû)'ÇÓ{#”ä‘#–w‚ù¡„#fT3Pt±(&»$iÂÂRògŠ‰EÔ-¡£éˆ, •®J‡ßõâM`¾ªÄ²®p1f3q>¬p¢«Îé|Ë’¡å;1Ïêò
äW»Jµétæ+şlË~t96ïäµN¤©êj
«„ó¬gNµÄ÷ŒÑ %#ëd>R–ÁòôÅÁ¢è,Q÷s¼½…±bƒsA‚ä8‹js Ğds<Ÿ¦3©ıß%“Ñ £‚Í0‚É0Uÿ0ÿ 0Uÿ†0U%0
+0y+m0k0$+0†http://ocsp.digicert.com0C+0†7http://cacerts.digicert.com/DigiCertAssuredIDRootCA.crt0Uz0x0: 8 6†4http://crl4.digicert.com/DigiCertAssuredIDRootCA.crl0: 8 6†4http://crl3.digicert.com/DigiCertAssuredIDRootCA.crl0OU H0F08
`†H†ıl 0*0(+https://www.digicert.com/CPS0
`†H†ıl0UZÄ¹{*
£¥êqÀ`ù-öeuX0U#0€Eë¢¯ô’Ë‚1-Q‹§§!ómÈ0	*†H†÷ ‚ >ìZ$³ó"ÑÈ,|%)v¨]-:Äï0a×~`ıÃ=Ä¯‹ıï*ß U7°áöÑ’uQ´n¥Zâ^$N¤î?qcK­×_Dyó6Š÷œFN\ÿ±‘ûº¯µQÂ$®$ÆÇ'*¡)(:q(<.‘£À%âœG¡zhh¯›§\ \Ùq±»¨øÅhŸÏ@Ë@D¥ğæd%B2²6Š$ş/r~×IE–èYéútdk²ëfCÚ³°ŒÕéİö Î™1c=³›OÆ“üú‹Úù‚I÷bn¡Sú”….’‘êhlD2²f¡ç¤šdQï1‚0‚0†0r10	UUS10U
DigiCert Inc10Uwww.digicert.com110/U(DigiCert SHA2 Assured ID Code Signing CA¾J»	É±ÖÂe0/0	`†He  0
+‚710 0
*†H†÷	10	
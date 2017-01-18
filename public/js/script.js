/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/js/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ({

/***/ 0:
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	__webpack_require__(77);

/***/ },

/***/ 77:
/***/ function(module, exports) {

	"use strict";
	
	var Myclock = function Myclock() {
		var clock, ctx, cX, cY, R;
		var buffer = null; //сохраняем область canvas которая не меняется
	
		var now = new Date();
	
		var position = {
			sec: {
				x: null,
				y: null
			},
			min: {
				x: null,
				y: null
			},
			hrs: {
				x: null,
				y: null
			}
		};
	
		function drawClockBody() {
			ctx.save();
			ctx.beginPath();
			ctx.lineWidth = "1";
			ctx.strokeStyle = "#00bcd4";
			ctx.arc(cX, cY, R, 0, Math.PI * 2);
			ctx.stroke();
			ctx.beginPath();
			ctx.lineWidth = "3";
			ctx.strokeStyle = "#0596a9";
			ctx.arc(cX, cY, R + 5, 0, Math.PI * 2);
			ctx.stroke();
			ctx.restore();
		}
	
		function drawSeconds() {
			var angleS = now.getSeconds() * Math.PI / 30 - Math.PI / 2;
			position.sec.x = cX + Math.cos(angleS) * R * 0.9; //координаты конца секундной стрелки
			position.sec.y = cY + Math.sin(angleS) * R * 0.9; //координаты конца секундной стрелки
			ctx.beginPath(); //новая линия
			ctx.strokeStyle = "#045661";
			ctx.moveTo(cX, cY); //начало линии в центре окружности
			ctx.lineTo(position.sec.x, position.sec.y); //конец линии
			ctx.stroke(); //обвели полученную фигуру
		}
	
		function drawMinutes() {
			ctx.save(); // сохраняет состояние для этой функции
			var angleM = now.getMinutes() * Math.PI / 30 - Math.PI / 2;
			position.min.x = cX + Math.cos(angleM) * R * 0.7;
			position.min.y = cY + Math.sin(angleM) * R * 0.7;
			ctx.beginPath();
			ctx.lineWidth = 3; // толщина минутной стрелки
			ctx.lineCap = 'round'; // закругленый конец линии
			ctx.moveTo(cX, cY);
			ctx.lineTo(position.min.x, position.min.y);
			ctx.stroke();
			ctx.restore(); //востанавливает состаяние 
		}
	
		function drawHours() {
			ctx.save();
			var angleH = now.getHours() * Math.PI / 6 - Math.PI / 2;
			position.hrs.x = cX + Math.cos(angleH) * R * 0.5;
			position.hrs.y = cY + Math.sin(angleH) * R * 0.5;
			ctx.beginPath();
			ctx.lineWidth = 5;
			ctx.lineCap = 'round';
			ctx.moveTo(cX, cY);
			ctx.lineTo(position.hrs.x, position.hrs.y);
			ctx.stroke();
			ctx.restore();
		}
		function drawClockFace() {
			ctx.save();
			ctx.lineWidth = 6;
			ctx.strokeStyle = 'gray';
			for (var i = 0; i < 4; i++) {
				ctx.beginPath();
				var angle = i * Math.PI / 2;
				var dx = Math.cos(angle) * R;
				var dy = Math.sin(angle) * R;
				ctx.moveTo(cX + 0.85 * dx, cY + 0.85 * dy);
				ctx.lineTo(cX + 0.95 * dx, cY + 0.95 * dy);
				ctx.stroke();
			}
			ctx.restore();
		}
		function init(canvasId) {
			if (canvasId && canvasId.length > 0) {
				clock = document.getElementById(canvasId);
				if (clock === null) {
					console.error('Myclock init error: элемент canvas с id = "' + canvasId + '" не найден');
					return -1;
				}
			} else {
				console.error('Myclock init error: не задан идентификатор холста');
				return -1;
			}
			clock.width = 400;
			clock.height = 400; // размер холста
			ctx = clock.getContext('2d'); //получили контекст рисования в двумерной плоскости
			cX = clock.offsetLeft + clock.width / 2; //центр холста по Х
			cY = clock.offsetTop + clock.height / 2; //центр холста по У
			R = 150; // радиус окружности циферблата
	
			console.log(cX + ' ' + cY);
			drawClockBody();
			drawClockFace();
			buffer = ctx.getImageData(0, 0, clock.width, clock.height);
			setInterval(update, 1000);
		}
	
		function update() {
			now = new Date();
			ctx.putImageData(buffer, 0, 0);
			drawSeconds();
			drawMinutes();
			drawHours();
		}
		//public
		this.init = init;
	};
	var myclock = new Myclock();
	myclock.init("example-clock");
	$(document).ready(function () {});

/***/ }

/******/ });
//# sourceMappingURL=script.js.map
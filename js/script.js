$(function() {
	var t = this;
	var eventSource = [{
		events: []
	}];
	var vars = [],
		hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	for (var i = 0; i < hashes.length; i++) {
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}

	this.label = vars["label"];

	function displayed(view) {
		$(".fc-header-center").text(decodeURI(t.label) + "地区のカレンダー");
	}
	$.get("ics/"+t.label+".ics", function(csvdata) {
		var csvdata = csvdata.replace("/\r/gm", "");
		var tmp = csvdata.split("\n");
		var date = "";
		var title = "";
		for (var i in tmp) {
			if (/^DTSTART;VALUE=DATE:(\d{4})(\d{2})(\d{2})/.test(tmp[i])) {
				date = RegExp.$1 + "-" + RegExp.$2 + "-" + RegExp.$3;
			}
			if (/^SUMMARY:(.+)/.test(tmp[i])) {
				title = RegExp.$1;
				eventSource[0]["events"].push({
					title: title,
					start: date
				});
			}
		};
		$('#calendar').fullCalendar({

			header: {
				// title, prev, next, prevYear, nextYear, today
				left: 'title',
				center: '',
				right: 'prev,next today'
			},
			// タイトルの書式
			titleFormat: {
				month: 'yyyy年M月', // 2013年9月
				week: "yyyy年M月d日{ ～ }{[yyyy年]}{[M月]d日}", // 2013年9月7日 ～ 13日
				day: "yyyy年M月d日'('ddd')'" // 2013年9月7日(火)
			},
			// ボタン文字列
			buttonText: {
//				prev: '&lsaquo;', // <
//				next: '&rsaquo;', // >
				prev: '前の月', // <
				next: '次の月', // >
				prevYear: '&laquo;', // <<
				nextYear: '&raquo;', // >>
				today: '今日',
				month: '月',
				week: '週',
				day: '日'
			},
			viewDisplay: displayed,
			// 月名称
			monthNames: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
			// 月略称
			monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
			// 曜日名称
			dayNames: ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'],
			// 曜日略称
			dayNamesShort: ['日', '月', '火', '水', '木', '金', '土'],
			eventSources: eventSource
		});
	});



});
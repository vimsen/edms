<?php
$template =
<<<EOD
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html">
                <meta charset="UTF-8">
		<style type="text/css">
			/* Mobile-specific Styles */
			@media only screen and (max-device-width: 480px) {
				table[class=w0], td[class=w0] {
					width: 0 !important;
				}
				table[class=w10], td[class=w10], img[class=w10] {
					width: 10px !important;
				}
				table[class=w15], td[class=w15], img[class=w15] {
					width: 5px !important;
				}
				table[class=w30], td[class=w30], img[class=w30] {
					width: 10px !important;
				}
				table[class=w60], td[class=w60], img[class=w60] {
					width: 10px !important;
				}
				table[class=w125], td[class=w125], img[class=w125] {
					width: 80px !important;
				}
				table[class=w130], td[class=w130], img[class=w130] {
					width: 55px !important;
				}
				table[class=w140], td[class=w140], img[class=w140] {
					width: 90px !important;
				}
				table[class=w160], td[class=w160], img[class=w160] {
					width: 180px !important;
				}
				table[class=w170], td[class=w170], img[class=w170] {
					width: 100px !important;
				}
				table[class=w180], td[class=w180], img[class=w180] {
					width: 80px !important;
				}
				table[class=w195], td[class=w195], img[class=w195] {
					width: 80px !important;
				}
				table[class=w220], td[class=w220], img[class=w220] {
					width: 80px !important;
				}
				table[class=w240], td[class=w240], img[class=w240] {
					width: 180px !important;
				}
				table[class=w255], td[class=w255], img[class=w255] {
					width: 185px !important;
				}
				table[class=w275], td[class=w275], img[class=w275] {
					width: 135px !important;
				}
				table[class=w280], td[class=w280], img[class=w280] {
					width: 135px !important;
				}
				table[class=w300], td[class=w300], img[class=w300] {
					width: 140px !important;
				}
				table[class=w325], td[class=w325], img[class=w325] {
					width: 95px !important;
				}
				table[class=w360], td[class=w360], img[class=w360] {
					width: 140px !important;
				}
				table[class=w410], td[class=w410], img[class=w410] {
					width: 180px !important;
				}
				table[class=w470], td[class=w470], img[class=w470] {
					width: 200px !important;
				}
				table[class=w580], td[class=w580], img[class=w580] {
					width: 1000px !important;
				}
				table[class=w640], td[class=w640], img[class=w640] {
					width: 1020px !important;
				}
				table[class*=hide], td[class*=hide], img[class*=hide], p[class*=hide], span[class*=hide] {
					display: none !important;
				}
				table[class=h0], td[class=h0] {
					height: 0 !important;
				}
				p[class=footer-content-left] {
					text-align: center !important;
				}
				#headline p {
					font-size: 30px !important;
				}
				.article-content, #left-sidebar {
					-webkit-text-size-adjust: 90% !important;
					-ms-text-size-adjust: 90% !important;
				}
				.header-content, .footer-content-left {
					-webkit-text-size-adjust: 80% !important;
					-ms-text-size-adjust: 80% !important;
				}
				img {
					height: auto;
					line-height: 100%;
				}
			}
			/* Client-specific Styles */
			#outlook a {
				padding: 0;
			}/* Force Outlook to provide a "view in browser" button. */
			body {
				width: 100% !important;
			}
			.ReadMsgBody {
				width: 100%;
			}
			.ExternalClass {
				width: 100%;
				display: block !important;
			}/* Force Hotmail to display emails at full width */
			/* Reset Styles */
			/* Add 100px so mobile switch bar doesn't cover street address. */
			body {
				background-color: #dedede;
				margin: 0;
				padding: 0;
			}
			img {
				outline: none;
				text-decoration: none;
				display: block;
			}
			br, strong br, b br, em br, i br {
				line-height: 100%;
			}
			h1, h2, h3, h4, h5, h6 {
				line-height: 100% !important;
				-webkit-font-smoothing: antialiased;
			}
			h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
				color: blue !important;
			}
			h1 a:active, h2 a:active, h3 a:active, h4 a:active, h5 a:active, h6 a:active {
				color: red !important;
			}
			/* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
			h1 a:visited, h2 a:visited, h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
				color: purple !important;
			}
			/* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
			table td, table tr {
				border-collapse: collapse;
			}
			.yshortcuts, .yshortcuts a, .yshortcuts a:link, .yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span {
				color: black;
				text-decoration: none !important;
				border-bottom: none !important;
				background: none !important;
			}/* Body text color for the New Yahoo.  This example sets the font of Yahoo's Shortcuts to black. */
			/* This most probably won't work in all email clients. Don't include <code _tmplitem="340" > blocks in email. */
			code {
				white-space: normal;
				word-break: break-all;
			}
			#background-table {
				background-color: #dedede;
			}
			/* Webkit Elements */
			#top-bar {
				
				background-color:white;
				color: #ededed;
			}
			#top-bar a {
				font-weight: bold;
				color: #ffffff;
				text-decoration: none;
			}
			#footer {
				
			}
			/* Fonts and Content */
			body, td {
				font-family: 'Helvetica Neue', Arial, Helvetica, Geneva, sans-serif;
			}
			.header-content, .footer-content-left, .footer-content-right {
				-webkit-text-size-adjust: none;
				-ms-text-size-adjust: none;
			}
			/* Prevent Webkit and Windows Mobile platforms from changing default font sizes on header and footer. */
			.header-content {
				font-size: 12px;
				color: #ededed;
			}
			.header-content a {
				font-weight: bold;
				color: #ffffff;
				text-decoration: none;
			}
        
        
                         .header-content2 {
				font-size: 12px;
				color: #ededed;
                                height:200px;
        background-color:white;
			}
			#headline p {
				color: #444444;
				font-family: 'Helvetica Neue', Arial, Helvetica, Geneva, sans-serif;
				font-size: 36px;
				text-align: center;
				margin-top: 0px;
				margin-bottom: 30px;
			}
			#headline p a {
				color: #444444;
				text-decoration: none;
			}
			.article-title {
				font-size: 18px;
				line-height: 24px;
				color: #b0b0b0;
				font-weight: bold;
				margin-top: 0px;
				margin-bottom: 18px;
				font-family: 'Helvetica Neue', Arial, Helvetica, Geneva, sans-serif;
			}
			.article-title a {
				color: #b0b0b0;
				text-decoration: none;
			}
			.article-title.with-meta {
				margin-bottom: 0;
			}
			.article-meta {
				font-size: 13px;
				line-height: 20px;
				color: #ccc;
				font-weight: bold;
				margin-top: 0;
			}
			.article-content {
				font-size: 13px;
				line-height: 18px;
				color: #444444;
				margin-top: 0px;
				margin-bottom: 18px;
				font-family: 'Helvetica Neue', Arial, Helvetica, Geneva, sans-serif;
			}
			.article-content a {
				color: #2f82de;
				font-weight: bold;
				text-decoration: none;
			}
			.article-content img {
				max-width: 100%
			}
			.article-content ol, .article-content ul {
				margin-top: 0px;
				margin-bottom: 18px;
				margin-left: 19px;
				padding: 0;
			}
			.article-content li {
				font-size: 13px;
				line-height: 18px;
				color: #444444;
			}
			.article-content li a {
				color: #2f82de;
				text-decoration: underline;
			}
			.article-content p {
				margin-bottom: 15px;
			}
			.footer-content-left {
				font-size: 12px;
				line-height: 15px;
				color: #ededed;
				margin-top: 0px;
				margin-bottom: 15px;
			}
			.footer-content-left a {
				color: #ffffff;
				font-weight: bold;
				text-decoration: none;
			}
			.footer-content-right {
				font-size: 11px;
				line-height: 16px;
				color: #ededed;
				margin-top: 0px;
				margin-bottom: 15px;
			}
			.footer-content-right a {
				color: #ffffff;
				font-weight: bold;
				text-decoration: none;
			}
			#footer {
				background-color: #c7c7c7;
				color: #ededed;
			}
			#footer a {
				color: #ffffff;
				text-decoration: none;
				font-weight: bold;
			}
			#permission-reminder {
				white-space: normal;
			}
			#street-address {
				color: #b0b0b0;
				white-space: normal;
			}
        
        /* table.css */
       
/**
 * Styles for tables and grid view
 */

.table, .with-head {
	margin-bottom: 1.667em;
	border: 1px solid #999999;
	}
	.table {
		border-collapse: collapse;
		width: 100%;
	}
	.table:last-child,
	.with-head:last-child {
		margin-bottom: 0;
	}
	/* IE class */
	.table.last-child,
	.with-head.last-child {
		margin-bottom: 0;
	}
	.no-margin .table,
	.content-columns .table,
	.with-head.no-margin,
	.content-columns .with-head {
		border: none;
	}
	.no-margin .table + .no-margin,
	.with-head.no-margin + .no-margin {
		margin-top: -1.667em;
		}
		.no-margin .table.last-child + .no-margin,
		.with-head.no-margin.last-child + .no-margin {
			margin-top: 0;
		}
	.content-columns .table:first-child,
	.content-columns .with-head:first-child {
		border: none;
	}
	/* IE class */
	.content-columns .table.first-child,
	.content-columns .with-head.first-child {
		border: none;
	}
	.content-columns .table,
	.content-columns .with-head {
		margin-bottom: 0;
	}
	.table thead th,
	.table thead td,
	.head {
		background: #a4a4a4 url(../images/old-browsers-bg/planning-header-bg.png) repeat-x top;
		
		background-size: 100% 100%;
		background: -moz-linear-gradient(
			top,
			#cccccc,
			#a4a4a4
		);
		background: -webkit-gradient(
			linear,
			left top, left bottom,
			from(#cccccc),
			to(#a4a4a4)
		);
		color: white;
		
		border-top: 1px solid white;
		border-left: 1px solid #dddddd;
		border-right: 1px solid #999999;
		border-bottom: 1px solid #828282;
	}
	.table thead th,
	.table thead td {
		vertical-align: middle;
		text-align: left;
		padding: 0.5em 0.75em;
		}
		.table thead th.sorting, .table thead th.sorting_asc, .table thead th.sorting_desc,
		.table thead td.sorting, .table thead td.sorting_asc, .table thead td.sorting_desc {
			cursor: pointer;
		}
	.head {
		font-weight: bold;
		line-height: 1.5em;
		}
		.head > div {
			float: left;
			padding: 0.5em 2em 0.5em 0.75em;
			border-left: 1px solid #dddddd;
			border-right: 1px solid #999999;
			color: white;
			margin: -1px 0 0 0;
			
			}
			.head > div:first-child {
				margin-left: -1px;
			}
			/* IE class */
			.head > div.first-child {
				margin-left: -1px;
			}
			.head > div:last-of-type {
				border-right: none;
			}
			/* IE class */
			.head > div.last-of-type {
				border-right: none;
			}

	.head .button {
		float: right;
		margin: 0.25em 0.5em 0 0;
	}
	.head > div .button {
		float: left;
		margin: -0.167em 0.5em -0.333em 0;
		}
		.head > div .button:last-child {
			margin-right: 0;
		}
		/* IE class */
		.head > div .button.last-child {
			margin-right: 0;
		}

	.table tbody th,
	.table tbody td,
	.table tfoot th,
	.table tfoot td {
		vertical-align: middle;
		text-align: left;
		padding: 0.75em;
		border-left: 1px dotted #333333;
		}
		.table tbody th,
		.table tbody .th {	/* Compatibility with DataTables */
			background: #e6e6e6;
		}
		.table tbody td {
			background: #f2f2f2;
		}
		.table tfoot th,
		.table tfoot td {
			border-top: 1px solid #FF9900;
			background: #999999 url(../images/old-browsers-bg/tfoot-bg.png) repeat-x top;
			-o-background-size: 100% 100%;
			-moz-background-size: 100% 100%;
			-webkit-background-size: 100% 100%;
			background-size: 100% 100%;
			background: -moz-linear-gradient(
				top,
				#333333,
				#999999
			);
			background: -webkit-gradient(
				linear,
				left top, left bottom,
				from(#333333),
				to(#999999)
			);
			color: white;
		}
		.table tbody th:first-child,
		.table tbody .th:first-child,
		.table tbody td:first-child,
		.table tfoot th:first-child,
		.table tfoot td:first-child {
			border-left: none;
		}
		/* IE class */
		.table tbody th.first-child,
		.table tbody .th.first-child,
		.table tbody td.first-child,
		.table tfoot th.first-child,
		.table tfoot td.first-child {
			border-left: none;
		}
		.table tbody tr:nth-child(even) th,
		.table tbody tr:nth-child(even) .th {
			background: #d9d9d9;
		}
		/* IE class */
		.table tbody tr.even th,
		.table tbody tr.even .th {
			background: #d9d9d9;
		}
		.table tbody tr:nth-child(even) td {
			background: #e6e6e6;
		}
		/* IE class */
		.table tbody tr.even td {
			background: #e6e6e6;
		}
		.table tbody tr:hover th,
		.table tbody tr:hover .th,
		.table tbody tr:hover td {
			background: #d1e5ef;
		}

	.table .black-cell,
	.head .black-cell {
		background: #242424 url(../images/old-browsers-bg/black-cell-bg.png) repeat-x top;
		-webkit-background-size: 100% 100%;
		-moz-background-size: 100% 100%;
		-o-background-size: 100% 100%;
		background-size: 100% 100%;
		background: -moz-linear-gradient(
			top,
			#4c4c4c,
			#242424
		);
		background: -webkit-gradient(
			linear,
			left top, left bottom,
			from(#4c4c4c),
			to(#242424)
		);
		border-top-color: #7f7f7f;
		border-left: none;
		border-right-color: #191919;
		min-width: 1.333em;
		padding: 0.5em 0.583em;
		}
		/* IE class */
		.ie7 .head .black-cell {
			height: 1.5em;
			position: relative;
			z-index: 89;
		}
		.head .black-cell.with-gap {
			border-right-color: white;
			margin-right: 0.25em
			}
			.head .black-cell.with-gap + .black-cell {
				border-left: 1px solid #999999;
			}
		.table .black-cell span,
		.head .black-cell span {
			display: block;
			height: 2.5em;
			background-repeat: no-repeat;
			background-position: center;
			margin: -0.5em -0.75em;
			}
			/* IE class */
			.ie7 .head .black-cell span {
				position: absolute;
				top: 0;
				right: 0;
				bottom: 0;
				left: 0;
				height: auto;
				padding: 0;
			}
			.table .black-cell span.loading, .with-head .black-cell span.loading { background-image: url(../images/table-loader.gif); }
			.table .black-cell span.error, .with-head .black-cell span.error { background-image: url(../images/icons/fugue/cross-circle.png); }
			.table .black-cell span.success, .with-head .black-cell span.success { background-image: url(../images/icons/fugue/tick-circle-blue.png); }

			.head > div.black-cell:last-of-type {
				border-right: 1px solid white;
			}
			/* IE class */
			.head > div.black-cell.last-of-type {
				border-right: 1px solid white;
			}

	.table-actions a img {
		margin: -2px 0;
	}

/************ Sort arrows ************/
.column-sort {
	display: block;
	float: left;
	width: 14px;
	margin: -0.583em 0.5em -0.583em -0.75em;
	border-right: 1px solid #dddddd;
	}
	.head .column-sort {
		margin: -0.5em 0.5em -0.5em -0.75em;
	}
	.sorting_disabled .column-sort {
		display: none;
	}
	.column-sort .sort-up,
	.column-sort .sort-down {
		display: block;
		width: 13px;
		height: 14px;
		background: url(../images/table-sort-arrows.png) no-repeat;
		border-right: 1px solid #999999;
	}
	.column-sort .sort-up {
		background-position: 0 1px;
		border-bottom: 1px solid #828282;
	}
	.column-sort .sort-down {
		background-position: 0 bottom;
		border-top: 1px solid white;
	}
	.column-sort .sort-up:hover { background-position: -15px 1px; }
	.column-sort .sort-down:hover { background-position: -15px bottom; }
	.column-sort .sort-up:active, .column-sort .sort-up.active, .sorting_asc .column-sort .sort-up { background-position: -30px 1px; }
	.column-sort .sort-down:active, .column-sort .sort-down.active, .sorting_desc .column-sort .sort-down { background-position: -30px bottom; }

/************ Cell styles ************/
.table-check-cell {
	width: 1em;
}

/* http://perishablepress.com/press/2008/02/05/lessons-learned-concerning-the-clearfix-css-hack */
.head:after,
ul.grid:after {
	clear: both;
	content: ' ';
	display: block;
	font-size: 0;
	line-height: 0;
	visibility: hidden;
	width: 0;
	height: 0;
}

.head,
ul.grid {
	display: inline-block;
}

* html .head,
* html ul.grid {
	height: 1%;
}

.head,
ul.grid {
	display: block;
}		</style>
		<!--[if gte mso 9]>
		<style _tmplitem="340" >
		.article-content ol, .article-content ul {
		margin: 0 0 0 24px;
		padding: 0;
		list-style-position: inside;
		}
        
 		</style>
		<![endif]-->
	</head>
	<body>
		<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" id="background-table">
			<tbody>
				<tr>
					<td align="center" bgcolor=" #c7c7c7">
					<table class="w640" style="margin:0 10px;" width="1020" cellpadding="0" cellspacing="0" border="0">
						<tbody>
                                                    <tr>
								<td class="w640" width="1020">
								<table id="top-bar" class="w640" width="1020" cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF">
									<tbody>
										<tr>
											<td class="w15" width="15"></td>
											<td class="w325" width="350" valign="middle" align="left">
											<table class="w325" width="350" cellpadding="0" cellspacing="0" border="0">
												<tbody>
													<tr>
														<td class="w325" width="350" height="8"></td>
													</tr>
												</tbody>
											</table>
                                                                                       <div class="header-content2">
												<span class="hide" style="color:red; font-weight: bold">
                                                                                                     <img src='https://beta.intelen.com/vimsen-logo1sca.jpg'>
                                                                                                </span>
											</div>
											<div class="header-content">
												<span class="hide" style="color:red; font-weight: bold">
                                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VIMSEN Notification Alert
                                                                                                </span>
											</div>
											<table class="w325" width="350" cellpadding="0" cellspacing="0" border="0">
												<tbody>
													<tr>
														<td class="w325" width="350" height="8"></td>
													</tr>
												</tbody>
											</table></td>
											<td class="w30" width="30"></td>
											<td class="w255" width="255" valign="middle" align="right">
											<table class="w255" width="255" cellpadding="0" cellspacing="0" border="0">
												<tbody>
													<tr>
														<td class="w255" width="255" height="8"></td>
													</tr>
												</tbody>
											</table>
											<table class="w255" width="255" cellpadding="0" cellspacing="0" border="0">
												<tbody>
													<tr>
														<td class="w255" width="255" height="8"></td>
													</tr>
												</tbody>
											</table></td>
											<td class="w15" width="15"></td>
										</tr>
									</tbody>
								</table></td>
							</tr>
							<tr>
								<td id="header" class="w640" width="1020" align="center" bgcolor="#FFFFFF">
								<div align="center" style="text-align: center">
								
								</div></td>
							</tr>

							<tr>
								<td class="w640" width="1020" height="30" bgcolor="#ffffff"></td>
							</tr>
							<tr id="simple-content-row">
								<td class="w640" width="1020" bgcolor="#ffffff">
								<table class="w640" width="1020" cellpadding="0" cellspacing="0" border="0">
									<tbody>
										<tr>
											<td class="w30" width="30"></td>
											<td class="w580" width="580">
                                                                                            $templateData
											</td>
											<td class="w30" width="30"></td>
										</tr>
									</tbody>
								</table></td>
							</tr>
							<tr>
								<td class="w640" width="1020" height="15" bgcolor="#ffffff"></td>
							</tr>

							<tr>
								<td class="w640" width="1020">
								<table id="footer" class="w640" width="1020" cellpadding="0" cellspacing="0" border="0" bgcolor="#c7c7c7">
									<tbody>
										<tr>
											<td class="w30" width="30"></td><td class="w580 h0" width="360" height="30"></td><td class="w0" width="60"></td><td class="w0" width="160"></td><td class="w30" width="30"></td>
										</tr>
										<tr>
											<td class="w30" width="30"></td>
											<td class="w580" width="360" valign="top"><span class="hide">
												<p id="permission-reminder" align="left" class="footer-content-left">
													<span></span>
												</p></span>
											<p align="left" class="footer-content-left">
												<!--preferences lang="el-GR">
													<a href="https://products.intelen.com/building/us/thresholds">Edit your preferences</a>
												</preferences-->
											</p></td>
											<td class="hide w0" width="60"></td>
											<td class="hide w0" width="160" valign="top"><p id="street-address" align="right" class="footer-content-right"></p></td>
											<td class="w30" width="30"></td>
										</tr>
										<tr>
											<td class="w30" width="30"></td><td class="w580 h0" width="360" height="15"></td><td class="w0" width="60"></td><td class="w0" width="160"></td><td class="w30" width="30"></td>
										</tr>
									</tbody>
								</table></td>
							</tr>
							<tr>
								<td class="w640" width="1020" height="60"></td>
							</tr>
						</tbody>
					</table></td>
				</tr>
			</tbody>
		</table>
	</body>
</html>
EOD;
?>
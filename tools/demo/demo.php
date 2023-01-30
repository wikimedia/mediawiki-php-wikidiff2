<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST'):

?>
<!DOCTYPE html>
<html>
<head>
<style>
.full-width {
	width: 100%;
}
.half-height {
	height: 50vh;
}
.params input {
	width: 100%;
}
</style>
<link rel="stylesheet" href="diff.css">
</head>
<body>
<table width="100%" class="diff">
	<colgroup>
		<col class="diff-marker">
		<col class="diff-content">
		<col class="diff-marker">
		<col class="diff-content">
	</colgroup>

	<tbody id="the-tbody">
		<tr>
			<td colspan="4">
				<table width="100%">
					<tr class="params">
						<td>
							<label>numContextLines<br>
							<input type="text" value="2" id="numContextLines"></label>
						</td>
						<td>
							<label>changeThreshold<br>
							<input type="text" value="0.2" id="changeThreshold"></label>
						</td>
						<td>
							<label>movedLineThreshold<br>
							<input type="text" value="0.4" id="movedLineThreshold"></label>
						</td>
						<td>
							<label>maxMovedLines<br>
							<input type="text" value="100" id="maxMovedLines"></label>
						</td>
						<td>
							<label>maxWordLevelDiffComplexity<br>
							<input type="text" value="40000000" id="maxWordLevelDiffComplexity"></label>
						</td>
						<td>
							<label>maxSplitSize<br>
							<input type="text" value="3" id="maxSplitSize"></label>
						</td>
						<td>
							<label>initialSplitThreshold<br>
							<input type="text" value="0.1" id="initialSplitThreshold"></label>
						</td>
						<td>
							<label>finalSplitThreshold<br>
							<input type="text" value="0.6" id="finalSplitThreshold"></label>
						</td>
					<tr>
				</table>
			<td>
		<tr>
			<td class="diff-marker"></td>
			<td>
				<textarea class="full-width half-height" id="lhs"></textarea>
			</td>
			<td class="diff-marker"></td>
			<td>
				<textarea class="full-width half-height" id="rhs"></textarea>
			</td>
		</tr>
		<tr id="last-header-row">
			<td colspan="4" id="perf-info"></td>
		</tr>
	</tbody>
</table>
<script>
(function () {
	const lhs = document.getElementById("lhs");
	const rhs = document.getElementById("rhs");
	const resultTbody = document.getElementById("the-tbody");
	const hdrRow = document.getElementById('last-header-row');
	const perfInfo = document.getElementById("perf-info");
	let options = [];

	const inputs = document.getElementsByTagName("input");
	for (const input of inputs) {
		options.push(input);
	}

	function updateDiff() {
		const req = new XMLHttpRequest();
		req.onload = function () {
			const tempTbody = document.createElement('tbody');
			tempTbody.innerHTML = req.responseText;
			while (hdrRow.nextSibling) {
				resultTbody.removeChild(hdrRow.nextSibling);
			}
			while (tempTbody.firstChild) {
				resultTbody.appendChild(tempTbody.firstChild);
			}
			perfInfo.replaceChildren(
				document.createTextNode(req.getResponseHeader("Diff-Timing")));
		};
		const data = new FormData();
		data.append("lhs", lhs.value);
		data.append("rhs", rhs.value);

		for (const option of options) {
			data.append("options[" + option.id + "]", option.value);
		}

		req.open("POST", "demo.php");
		req.send(data);
	}

	updateDiff();
	lhs.addEventListener("change", updateDiff);
	lhs.addEventListener("keyup", updateDiff);
	rhs.addEventListener("change", updateDiff);
	rhs.addEventListener("keyup", updateDiff);

	for (const option of options) {
		option.addEventListener("change", updateDiff);
	}
})();
</script>
</body>
</html>
<?php
	else:
	{
		$t = -microtime( true );
		$diffs = wikidiff2_multi_format_diff(
			str_replace( "\r\n", "\n", $_POST['lhs'] ?? '' ),
			str_replace( "\r\n", "\n", $_POST['rhs'] ?? '' ),
			$_POST['options'] ?? []
		);
		$t += microtime( true );
		$diff = reset( $diffs );
		$diff = preg_replace( '/<!--LINE ([0-9]+)-->/', 'Line \1', $diff );
		header( "Diff-Timing: " . round( $t * 1000, 3 ) . " ms" );
		echo $diff;
	}
endif
?>

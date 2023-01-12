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
		req.open("POST", "demo.php");
		req.send(data);
	}

	updateDiff();
	lhs.addEventListener("change", updateDiff);
	lhs.addEventListener("keyup", updateDiff);
	rhs.addEventListener("change", updateDiff);
	rhs.addEventListener("keyup", updateDiff);
})();
</script>
</body>
</html>
<?php
	else:
	{
		$t = -microtime( true );
		$diff = wikidiff2_do_diff(
			$_POST['lhs'] ?? '',
			$_POST['rhs'] ?? '',
			2
		);
		$diff = preg_replace( '/<!--LINE ([0-9]+)-->/', 'Line \1', $diff );
		$t += microtime( true );
		header( "Diff-Timing: " . round( $t * 1000, 3 ) . " ms" );
		echo $diff;
	}
endif
?>

<html>
<head>
	<title>Team Color</title>
	<link rel="stylesheet" type="text/css" href="css/team-colours.css">
	<link rel="stylesheet" type="text/css" href="css/teams.css">
</head>
<body>

	@foreach ($teams as $team)
		<div class="team{{$team->teamId}} team team">
			<div class="logo">
				<img src="{{$team->logo}}">
				<span class="city">{{$team->teamLocation}} </span>
				<span class="teamname">{{$team->teamNickname}}</span>
			</div>
		</div>
	@endforeach
</body>
</html>
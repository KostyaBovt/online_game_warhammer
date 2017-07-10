<div class="wrap-left">
<div class="create-game">
	<h3>Create new game:</h3>
	<a href="create_game.php"><button>Create</button></a>
</div>
<div class="games-list">
	<h3>Games aviable to join:</h3>
	<table>
		<tr>
			<td>GAME NAME</td>
			<td>JOIN</td>
		</tr>
        <?php
            foreach ($open_games as $open_game) {
                echo '<tr>';
                echo '<td>game #';
                echo $open_game->id;
                echo '</td>';
                echo '<td><a href="join_game.php?game_id=' . $open_game->id . '">join game!';
                echo '</td>';
                echo '<tr>';
            }
        ?>

	</table>
</div>

<div class="users-raiting">
	<h3>Raiting of players</h3>
    <div class="raiting">
    <?php
    $raitings = new Raiting();

    $rar = $raitings->get();

    for ($i = 0; $i < 5; $i++)
        if (isset($rar[$i])) {
            echo "<div class='raiting-line'>";
            foreach ($rar[$i] as $key => $item) {
                if ($key == 'login') {
                    echo "<span id=\"raiting-login\">" . $item . ": " . "</span>";
                }
                if ($key == 'wins') {
                    echo "<span id=\"raiting-wins\">" . $item. " wins" . "</span>";
                }
            }
            echo "</div>";
        }
    ?>
    </div>
</div>
</div>
<div class="chat">
	<h3>Chat</h3>
    <div class="chat-wind">
    <?php
            $mess = new Chat();
            $rez = $mess->get();
            rsort($rez);
            for ($i = 0; $i < 27; $i++) {
                if (isset($rez[$i])) {
                    echo "<div class='chat-line'>";
                    foreach ($rez[$i] as $key => $item) {
                        if ($key == 'message') {
                            echo "<span id=\"chat-message\">" . $item . "</span>";
                        } else if ($key == 'login') {
                            echo "<span id=\"chat-login\">" . $item . ": " . "</span>";
                        } else if ($key == 'created')
                            echo "<span id=\"chat-time\">" . $item . "</span>";
                    }
                    echo "</div>";
                }
            }
    ?>
    </div>
    <form class="chat_form" method="post" action="">
        <div>
            <input type="submit" name="submit" value="Send" id="chat_button">
            <input type="text" name="message" placeholder="Message" id="chat-input">
        </div>
    </form>
</div>
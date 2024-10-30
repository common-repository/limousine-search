<form>
    <div>
        <button id="reservation-p2p" type="button">P2P</button>
        <button id="reservation-hourly" type="button">Hourly</button>
    </div>

    <label for="origin">Origin</label>
    <input id="origin" name="origin" type="text" />

    <div class="js-p2p">
        <label for="origin">Destination</label>
        <input id="origin" name="origin" type="text" />
    </div>
    <div class="js-hourly hidden">
    <label for="duration">Duration</label>
        <select id="duration" name="duration">
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
        </select>
    </div>
    <button type="submit">Send</button>
</form>

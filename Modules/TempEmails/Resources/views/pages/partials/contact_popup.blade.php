<div id="small-dialog" class="zoom-anim-dialog mfp-hide">
    <div class="form_heading">
        <span><img src="{{moduleAssets('tempemails')}}/index/img/user.svg" alt="" width="145"></span>
        <h2>Hello, Nice to meet you</h2>
        <span>We'd love to hear from you</span>
    </div>
    <div class="fed_form">
        <form class="buzzForm">
            <fieldset>
                <div class="control-group">
                    <div class="control">
                        <label for="emailField">Email</label>
                        <input type="text" name="email" placeholder="Enter email" id="emailField">
                    </div>
                    <div class="control">
                        <label for="ageRangeField">Select Category</label>
                        <select id="ageRangeField" name="category">
                            <option>Report a bug</option>
                            <option>Give your Feedback</option>
                            <option>Not Getting Email</option>
                            <option>Other Issue</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label for="commentField">Message</label>
                    <textarea name="message" placeholder="Hi Tempemails ..." id="commentField"></textarea>
                </div>

                <input class="button button-blue" type="submit" value="Send">
            </fieldset>
        </form>
    </div>

</div>
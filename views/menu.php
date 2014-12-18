
        <main>
            <?php if (LoggedInUserIsAdmin()) : ?>

                Administration Items:<br />
                <ul>
                    <li><a href="/?action=editusers">Edit Users</a></li>
                </ul>

            <?php endif; ?>

            <ul>
                <li><a href="/?action=myinfo">Update my info</a></li>
                <li><a href="/?action=gallery">Like an item</a></li>
                <li><a href="/?action=newitem">Upload a new item</a></li>
                
            </ul>
        </main>

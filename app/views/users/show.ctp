<?php
/*
    Tatoeba Project, free collaborative creation of multilingual corpuses project
    Copyright (C) 2009  HO Ngoc Phuong Trang <tranglich@gmail.com>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// TODO create an helper for this 

$username = $user['User']['username'];
$userId =  $user['User']['id'];
$this->set('title_for_layout', $pages->formatTitle(format(
    __('Tatoeba user: {username}', true),
    compact('username')
)));
?>
<div id="annexe_content">

    <?php
        echo $this->element(
        'users_menu', 
        array('username' => $username)
    );
    ?>
    
    <?php
    /* Latest contributions from the user */
    if (count($user['Contributions']) > 0) {
        ?>
        <div class="module">
            <h2><?php __('Latest contributions'); ?></h2>
            <div id="logs">
            <?php
            foreach ($user['Contributions'] as $contribution) {
                $logs->annexeEntry($contribution);
            }
            ?>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<div id="main_content">
    <?php
    /* Latest sentences, translations or adoptions from the user */
    if (count($user['Sentences']) > 0) {
        echo '<div class="module">';
            echo '<h2>';
            __('Latest sentences');

            echo $html->link(
                __('view all', true),
                array(
                    "controller" => "sentences",
                    "action" => "of_user",
                    $username
                ),
                array(
                    'class' => 'titleAnnexeLink'
                )
            );
            echo '</h2>';
            
            $type = 'mainSentence';
            $parentId = null;
            $withAudio = false;
            $ownerName = $user['User']['username'];
            foreach ($user['Sentences'] as $sentence) {
                $sentences->displayGenericSentence(
                    $sentence,
                    $ownerName,
                    $type,
                    $parentId,
                    $withAudio
                );
            }
        echo '</div>';
    }
    
    /* Latest favorites from the user */
    if (count($user['Favorite']) > 0) {
        echo '<div class="module">';
            echo '<h2>';
            __('Favorite sentences');

            echo $html->link(
                __('view all', true),
                array(
                    "controller" => "favorites",
                    "action" => "of_user",
                    $user['User']['username']
                ),
                array(
                    'class' => 'titleAnnexeLink'
                )
            );
            echo '</h2>';

            
            $type = 'mainSentence';
            $parentId = null;
            $withAudio = false;
            $ownerName = null;
            foreach ($user['Favorite'] as $sentence) {
                $sentences->displayGenericSentence(
                    $sentence,
                    $ownerName,
                    $type,
                    $parentId,
                    $withAudio
                );
            }
            

        echo '</div>';
    }

    /* Latest comments from the user */
    if (count($user['SentenceComments']) > 0) {
        echo '<div class="module">';
            echo '<h2>';
            __('Latest comments');

            echo $html->link(
                __('view all', true),
                array(
                    "controller" => "sentence_comments",
                    "action" => "of_user",
                    $username
                ),
                array(
                    'class' => 'titleAnnexeLink'
                )
            );
            echo '</h2>';

            echo '<div class="comments">';
            foreach ($user['SentenceComments'] as $i => $comment) {
                $menu = $comments->getMenuForComment(
                    $comment,
                    $user['User'],
                    $commentsPermissions[$i]
                );

                $messages->displayMessage(
                    $comment,
                    $user['User'],
                    null,
                    $menu
                );
            }
            echo '</div>';
        echo '</div>';
    }
    
    
    /* Latest messages on the Wall */
    if (count($user['Wall']) > 0) {
        echo '<div class="module">';
            echo '<h2>';
            __('Latest Wall messages');

            echo $html->link(
                __('view all', true),
                array(
                    "controller" => "wall",
                    "action" => "messages_of_user",
                    $username
                ),
                array(
                    'class' => 'titleAnnexeLink'
                )
            );
            echo '</h2>';

            echo '<div class="wall">';
            foreach ($user['Wall'] as $comment) {
                $wall->createThread(
                    $comment,
                    $user['User'],
                    null,
                    null
                );
            }
            echo '</div>';
        echo '</div>';
    }
    ?>

</div>


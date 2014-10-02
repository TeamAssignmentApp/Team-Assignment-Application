Team-Assignment-Application
===========================
1. Create a github account if you do not already have one.
2. You will need to set up github with your public rsa key on your lyle server. There is a guide to this on the home page to do this.
3. Log in to your account and go to https://github.com/TeamAssignmentApp/Team-Assignment-Application
4. Click the "FORK" button in the top right hand corner. This will create a copy of the repo on your account.
5. Go to your copy of the repo on your account and find the SSH link on the page and copy it.
6. Log into your lyle account, go to your publichtml folder.
7. type in "git clone [paste the ssh link in here]". This will grab your copy down onto your lyle server where you can make edits.
8. type in "git branch". You should see that you are on the master branch. Always keep this as a clean copy of the code.

CREATING A BRANCH
Type in "git checkout -b [branch name]". This will create a new branch based on the branch you are currently on.

COMMITING CHANGES YOUVE MADE
If you want to commit all of the changes you have made, type in "git add -A". This will add all changes to be ready to commit. 
If you want to add specific files in your changes, type in "git add [path to file]"

You can use "git status" to see which files have been changed and what changes are ready in your commit.

To commit type in "git commit". This will open up an editor, I believe the default is VIM, but you can change it to nano if you would like.
Enter in a commit message on the first line and then save exit the editor.
The changes you have committed are now saved.

MERGING CHANGES FROM YOUR BRANCH INTO YOUR MASTER BRANCH
After making all changes on the branch you were working on, go back to the master branch.
To do so, type "git checkout master".
Next, you will type "git merge [name of branch you were working on]". 
This will pull all of the changes from your feature branch into your master branch.

PUSHING YOUR LOCAL CHANGES BACK TO YOUR GITHUB COPY OF THE REPO
If you type "git remote", you should see a list of your remotes, likely there is only origin.
This is the link to your github copy of the repo. 

To push a single branch up to github, type in "git push origin [branch name]". This will put your branch up onto your github repo.

MAKING A PULL REQUEST
Once you have made changes you want to go live on our AWS Instance you will make a pull request.
Go to github and then navigate to your copy of the code.
Go to your master branch and find the pull request button. 
Select your master branch and our MASTER master branch as the two branches to be merged.
Enter in a message for the pull request and click okay.

Someone will go in and accept the pull request into our MASTER master branch.

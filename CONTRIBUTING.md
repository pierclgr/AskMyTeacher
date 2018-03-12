# Contributing

If you want to contribute to this project, you have to follow the following steps.

### Contributing steps

- Create a fork of the project
- Clone the fork on your local machine; your remote repo on Github is called `origin`
- Add the original repository as a remote called `upstream`
  - If you created your fork a while ago be sure to pull `upstream` changes into your local repository
- Create a new branch to work on; branch from `master`
- Make your changes (implementing, fixes etc.); also, adding comments to code is appreciated
  - You're not forced to follow my coding style; however, please make the code easily readable following the basic indentation and writing style
- Write or adapt tests, following [README.md](README.md) tests guide
- Add or change the documentation
- Squash your commits into a single commit with git's interactive rebase
- Push your branch to your fork on Github, the remote `origin`
- From your fork open a pull request in the correct branch, targeting `master` branch
- Once the pull request is approved and merged you can pull the changes from `upstream` to your local repo and delete your extra branch (or branches)

Always write your commit messages in the present tense. Your commit message should describe what the commit, when applied, does to the code.
Once the pull request is approved and merged you'll get also full credits to changes applied.
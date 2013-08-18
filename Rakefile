task :default => [:deploy]

# Usage: rake preveiw


desc "deploy GitHub:Pages"
task :deploy do
	sh "php tocsv.php"
	sh "nkf -Lw --overwrite ical/*.ical"
	system "git commit -a"	
	sh "git push"
	sh "git checkout master"
end


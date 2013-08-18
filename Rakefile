task :default => [:deploy]

# Usage: rake preveiw


desc "deploy GitHub:Pages"
task :deploy do
	sh "php tocsv.php"
	sh "nkf -Lw --overwrite ics/*.ics"
	system "git commit -a"	
	sh "git push"
end


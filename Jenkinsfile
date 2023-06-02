pipeline {
    agent {
        docker { image 'php:8.1.11-alpine' }
    }

    stages {
        stage('Build') {
            steps {
                sh 'php composer.phar install'
            }
        }
    stage('Test') {
	steps {
		sh 'vendor/bin/phpunit --log-junit report.xml'
	}
        }
    }
    post {
        always {
            junit 'report.xml'
        }
    }
}

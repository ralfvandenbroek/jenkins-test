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
stage('SonarQube analysis') {
            steps {
                script {
                    // requires SonarQube Scanner 2.8+
                   scannerHome = tool 'SonarQube Scanner'
                }
                withSonarQubeEnv('SonarQube') {
                    sh 'printenv'
                    sh "${scannerHome}/bin/sonar-scanner -Dsonar.projectKey=test"
                }
            }
        }
}
    post {
        always {
            junit 'report.xml'
        }
    }
}

pipeline {
    agent {
        label '!windows'
    }

    environment {
        DISABLE_AUTH = 'true'
        DB_ENGINE    = 'sqlite'
    }

    stages {
        stage('Build') {
            steps {
                echo "Database engine is ${DB_ENGINE}"
                echo "DISABLE_AUTH is ${DISABLE_AUTH}"
                sh 'printenv'
            }
        }
        stage('SonarQube analysis') {
            steps {
                script {
                    // requires SonarQube Scanner 2.8+
                   scannerHome = tool 'SonarQubeScanner'
                }
                withSonarQubeEnv('SonarQube') {
                    sh 'printenv'
                    sh "${scannerHome}/bin/sonar-scanner"
                }
            }
        }
    }
}

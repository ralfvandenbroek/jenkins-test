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
            def scannerHome = tool 'SonarQube';
            withSonarQubeEnv('SonarQube') { // If you have configured more than one global server connection, you can specify its name
                sh "${scannerHome}/bin/sonar-scanner"
            }
        }
    }
}
